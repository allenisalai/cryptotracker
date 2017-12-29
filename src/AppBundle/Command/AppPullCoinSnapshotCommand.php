<?php

namespace AppBundle\Command;

use AppBundle\Entity\CoinDaySnapshot;
use AppBundle\Entity\CoinHourSnapshot;
use AppBundle\Entity\CoinMinuteSnapshot;
use AppBundle\Library\CryptoCompare\HistoryApiParameters;
use AppBundle\Library\CryptoCompare\HistoryApiToCoinSnapshot;
use AppBundle\Repository\CoinMinuteSnapshotRepository;
use DateTime;
use DateTimeImmutable;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppPullCoinSnapshotCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:pull-coin-snapshot')
            ->addArgument('coin-symbol', InputArgument::REQUIRED, 'Coin Symbol')
            ->addArgument('time-unit', InputArgument::OPTIONAL, 'Pulling the aggregate for a given unit of time: minute, hour, or day', 'hour')
            ->addOption('start-time', 't', InputOption::VALUE_OPTIONAL, 'Start time')
            ->addOption('record-count', 'r', InputOption::VALUE_OPTIONAL, 'Records pull at one time', 2000)
            ->addOption('to-symbol', 'o', InputOption::VALUE_OPTIONAL, 'The converting symbol', 'USD');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $coinSymbol        = $input->getArgument('coin-symbol');
        $timeUnit          = $input->getArgument('time-unit');
        $recordCount       = $input->getOption('record-count');
        $toSymbol          = $input->getOption('to-symbol');
        $historyParameters = new HistoryApiParameters();
        $historyApi        = new HistoryApiToCoinSnapshot();
        $guzzleClient      = new Client();

        $startTime = new DateTimeImmutable();
        if ($input->getOption('start-time') != null) {
            $startTime = new DateTimeImmutable($input->getOption('start-time'));
        }

        $historyParameters->setFromSymbol($coinSymbol)
                          ->setToSymbol($toSymbol)
                          ->setRecordLimit($recordCount)
                          ->setToTimestamp($startTime);

        /** @var CoinMinuteSnapshotRepository $coinSnapshotRepository */
        $coinSnapshotRepository = $this->getCoinSnapshotClassInstance($timeUnit);

        /** @var CoinMinuteSnapshot $mostRecentCoinSnapshot */
        $mostRecentCoinSnapshot = $coinSnapshotRepository->createQueryBuilder('cs')
                                                         ->where('cs.coinSymbol = :symbol')
                                                         ->setParameter('symbol', $coinSymbol)
                                                         ->setMaxResults(1)
                                                         ->orderBy('cs.time', ' DESC')
                                                         ->getQuery()
                                                         ->getOneOrNullResult();

        $url = $this->getApiUrl($timeUnit, $historyParameters, $historyApi);
        $output->writeln('Starting time: ' . $historyParameters->getToTimestamp()->format('Y-m-d h:ia'));
        $output->writeln('Url: <info>' . $url . "</info>");

        $em          = $this->getContainer()->get('doctrine')->getManager();
        $apiResponse = $guzzleClient->get($url);
        $coinRecords = $historyApi->getCoinSnapshotRecords((string) $apiResponse->getBody());

        $addedRecordCount = 0;
        /** @var CoinMinuteSnapshot $lastCoinSnapshot */
        $lastCoinSnapshot = null;
        while (count($coinRecords)) {

            /** @var CoinMinuteSnapshot $coinSnapshot */
            foreach ($coinRecords as $coinSnapshot) {

                // if we've hit the most recent time, break
                if ($mostRecentCoinSnapshot !== null
                    && $coinSnapshot->getTime()->getTimestamp() == $mostRecentCoinSnapshot->getTime()->getTimestamp()) {
                    $lastCoinSnapshot = $coinSnapshot;
                    $em->flush();
                    break 2;
                }

                $coinSnapshot->setCoinSymbol($coinSymbol)
                             ->setExchange('CCAGG');
                $em->persist($coinSnapshot);
                $addedRecordCount++;
                $lastCoinSnapshot = $coinSnapshot;

            }
            $em->flush();

            $newStartTime = new DateTime('now', new \DateTimeZone('UTC'));
            $newStartTime->setTimestamp($lastCoinSnapshot->getTime()->getTimestamp()
                - $this->getTimeUnitInSeconds($timeUnit));
            $historyParameters->setToTimestamp(DateTimeImmutable::createFromMutable($newStartTime));

            sleep(5);
            $apiResponse = $guzzleClient->get($this->getApiUrl($timeUnit, $historyParameters, $historyApi));
            $coinRecords = $historyApi->getCoinSnapshotRecords((string) $apiResponse->getBody());
        }

        if ($lastCoinSnapshot) {
            $output->writeln("Ending at:" . $lastCoinSnapshot->getTime()->format('Y-m-d h:ia'));
        }
        $output->writeln("<info>{$addedRecordCount} new record(s) were added.</info>");
    }


    /**
     * @param string $timeUnit
     *
     * @return mixed
     */
    private function getCoinSnapshotClassInstance(string $timeUnit)
    {
        $doctrine = $this->getContainer()->get('doctrine');

        switch ($timeUnit) {
            case HistoryApiToCoinSnapshot::TIME_UNIT_MINUTE:
                return $doctrine->getRepository(CoinMinuteSnapshot::class);
            case HistoryApiToCoinSnapshot::TIME_UNIT_HOUR:
                return $doctrine->getRepository(CoinHourSnapshot::class);
            case HistoryApiToCoinSnapshot::TIME_UNIT_DAY:
                return $doctrine->getRepository(CoinDaySnapshot::class);
        }
    }

    /**
     * @param string                   $timeUnit
     * @param HistoryApiParameters     $parameters
     * @param HistoryApiToCoinSnapshot $historyApi
     *
     * @return string
     */
    private function getApiUrl(string $timeUnit, HistoryApiParameters $parameters, HistoryApiToCoinSnapshot $historyApi)
    {
        switch ($timeUnit) {
            case HistoryApiToCoinSnapshot::TIME_UNIT_MINUTE:
                return $historyApi->getMinuteSnapshots($parameters);
            case HistoryApiToCoinSnapshot::TIME_UNIT_HOUR:
                return $historyApi->getHourSnapshots($parameters);
            case HistoryApiToCoinSnapshot::TIME_UNIT_DAY:
                return $historyApi->getDaySnapshots($parameters);
        }
    }

    /**
     * @param string $timeUnit
     *
     * @return int
     */
    private function getTimeUnitInSeconds(string $timeUnit): int
    {
        switch ($timeUnit) {
            case HistoryApiToCoinSnapshot::TIME_UNIT_MINUTE:
                return 60;
            case HistoryApiToCoinSnapshot::TIME_UNIT_HOUR:
                return 3600;
            case HistoryApiToCoinSnapshot::TIME_UNIT_DAY:
                return 86400;
        }
    }
}
