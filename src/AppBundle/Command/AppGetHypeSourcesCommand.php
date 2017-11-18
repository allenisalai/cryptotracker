<?php

namespace AppBundle\Command;

use AppBundle\Entity\Coin;
use AppBundle\Library\CryptoCompare\CoinListApi;
use AppBundle\Library\HypeSource\NewsArticleExtractor;
use AppBundle\Repository\CoinRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class AppGetHypeSourcesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:get-hype-sources');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get(NewsArticleExtractor::class)->extractHypeSources();
    }
}
