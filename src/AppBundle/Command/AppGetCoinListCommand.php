<?php

namespace AppBundle\Command;

use AppBundle\Entity\Coin;
use AppBundle\Library\CryptoCompare\CoinListApi;
use AppBundle\Repository\CoinRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class AppGetCoinListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:coin-list')
            ->addArgument('search', InputArgument::OPTIONAL, 'Search for coins by name')
            ->addOption('refresh-list', 'r', InputOption::VALUE_NONE, 'Refresh the list of coins.')
            ->addOption('limit', 'l', InputOption::VALUE_OPTIONAL, 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var bool $refreshList */
        $refreshList = $input->getOption('refresh-list');
        $limit = $input->getOption('limit');
        $coinListApi = new CoinListApi();
        $guzzleClient = new Client();


        if ($refreshList) {
            /** @var EntityManager $em */
            $em = $this->getContainer()->get('doctrine')->getManager();
            $em->createQuery('DELETE AppBundle:Coin c')->execute();

            $apiResponse = $guzzleClient->get($coinListApi->getUrl());
            $coinList = $coinListApi->getCoinRecords((string)$apiResponse->getBody());
            foreach ($coinList as $coin) {
                $em->persist($coin);
            }

            $em->flush();
        }


        $coinRepository = $this->getContainer()
            ->get('doctrine')
            ->getRepository(Coin::class);

        $table = $this->getCoinTable($output, $coinRepository, $input->getArgument('search'), $limit);
        $table->render();
    }

    private function getCoinTable(OutputInterface $output, CoinRepository $coinRepository, $search = null, $limit = 10)
    {
        $coinSql = $coinRepository->createQueryBuilder('c')
            ->select('c.coinSymbol, c.name, c.fullName, c.proofType, c.algorithm')
            ->setMaxResults($limit)
            ->orderBy('c.coinSymbol', 'ASC');

        if ($search !== null) {
            $coinSql->where('LOWER(c.coinSymbol) LIKE :search')
                ->orWhere('LOWER(c.name) LIKE :search')
                ->orWhere('LOWER(c.fullName) LIKE :search')
                ->setParameter('search', strtolower('%' . $search . '%'));
        }

        $coins = $coinSql->getQuery()->getArrayResult();

        $table = new Table($output);
        $table
            ->setHeaders(array('Symbol', 'Coin Name', 'Full Name', 'Proof Type', 'Algorithm'))
            ->setRows($coins);

        return $table;
    }
}
