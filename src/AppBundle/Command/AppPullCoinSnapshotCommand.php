<?php

namespace AppBundle\Command;

use AppBundle\Library\CryptoCompare\HistoryMinuteApiParameters;
use AppBundle\Library\CryptoCompare\HistoryMinuteApiToCoinSnapshot;
use AppBundle\Repository\CoinSnapshotRepository;
use DateTimeImmutable;
use GuzzleHttp\Psr7\Request;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DateTime;
use GuzzleHttp\Client;
use AppBundle\Entity\CoinSnapshot;

class AppPullCoinSnapshotCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:pull-coin-snapshot')
            ->addArgument('coin-symbol', InputArgument::REQUIRED, 'Coin Symbol')
            ->addOption('start-time', 't', InputOption::VALUE_OPTIONAL, 'Start time')
            ->addOption('record-count', 'r', InputOption::VALUE_OPTIONAL, 'Records pull at one time', 2000)
            ->addOption('to-symbol', 'o', InputOption::VALUE_OPTIONAL, 'The converting symbol', 'BTC');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $coinSymbol = $input->getArgument('coin-symbol');
        $recordCount = $input->getOption('record-count');
        $toSymbol = $input->getOption('to-symbol');
        $historyMinuteParameters = new HistoryMinuteApiParameters();
        $historyMinuteApi = new HistoryMinuteApiToCoinSnapshot();
        $guzzleClient = new Client();

        $startTime = new DateTimeImmutable();
        if ($input->getOption('start-time') != null) {
            $startTime = new DateTimeImmutable($input->getOption('start-time'));
        }

        $historyMinuteParameters->setFromSymbol($coinSymbol)
            ->setToSymbol($toSymbol)
            ->setRecordLimit($recordCount)
            ->setToTimestamp($startTime);

        /** @var CoinSnapshotRepository $coinSnapshotRepository */
        $coinSnapshotRepository = $this->getContainer()
            ->get('doctrine')
            ->getRepository(CoinSnapshot::class);

        /** @var CoinSnapshot $mostRecentCoinSnapshot */
        $mostRecentCoinSnapshot = $coinSnapshotRepository->createQueryBuilder('cs')
            ->where('cs.coinSymbol = :symbol')
            ->setParameter('symbol', $coinSymbol)
            ->setMaxResults(1)
            ->orderBy('cs.time', ' DESC')
            ->getQuery()
            ->getOneOrNullResult();

        $url = $historyMinuteApi->getUrl($historyMinuteParameters);
        $output->writeln('Starting time: ' . $historyMinuteParameters->getToTimestamp()->format('Y-m-d h:ia'));
        $output->writeln('Url: <info>' . $url . "</info>");


        $em = $this->getContainer()->get('doctrine')->getManager();
        $apiResponse = $guzzleClient->get($historyMinuteApi->getUrl($historyMinuteParameters));
        $coinRecords = $historyMinuteApi->getCoinSnapshotRecords((string)$apiResponse->getBody());

        $addedRecordCount = 0;
        /** @var CoinSnapshot $lastCoinSnapshot */
        $lastCoinSnapshot = null;
        while (count($coinRecords)) {

            /** @var CoinSnapshot $coinSnapshot */
            foreach ($coinRecords as $coinSnapshot) {

                // if we've hit the most recent time, break
                if ($mostRecentCoinSnapshot !== null && $coinSnapshot->getTime()->getTimestamp() == $mostRecentCoinSnapshot->getTime()->getTimestamp()) {
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
            $newStartTime->setTimestamp($lastCoinSnapshot->getTime()->getTimestamp() - 60);
            $historyMinuteParameters->setToTimestamp(DateTimeImmutable::createFromMutable($newStartTime));

            sleep(5);
            $apiResponse = $guzzleClient->get($historyMinuteApi->getUrl($historyMinuteParameters));
            $coinRecords = $historyMinuteApi->getCoinSnapshotRecords((string)$apiResponse->getBody());
        }

        if ($lastCoinSnapshot) {
            $output->writeln("Ending at:" . $lastCoinSnapshot->getTime()->format('Y-m-d h:ia'));
        }
        $output->writeln("<info>{$addedRecordCount} new record(s) were added.</info>");
    }
}
