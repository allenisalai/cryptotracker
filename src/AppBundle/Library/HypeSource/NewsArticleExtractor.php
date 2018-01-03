<?php

namespace AppBundle\Library\HypeSource;


use AppBundle\Entity\HypeSource;
use AppBundle\Library\HypeSource\NewsArticle\BitcoinMagazineParser;
use AppBundle\Library\HypeSource\NewsArticle\CoinDeskParser;
use AppBundle\Library\HypeSource\NewsArticle\CoinJournalParser;
use AppBundle\Library\HypeSource\NewsArticle\CoinNewsAsiaParser;
use AppBundle\Library\HypeSource\NewsArticle\CryptoNewsParser;
use AppBundle\Library\HypeSource\NewsArticle\CryptoNinjaParser;
use AppBundle\Library\HypeSource\NewsArticle\CryptoQuickNewsParser;
use AppBundle\Library\HypeSource\NewsArticle\FinanceMagnatesParser;
use AppBundle\Library\HypeSource\NewsArticle\HtmlSourceParserInterface;
use AppBundle\Library\HypeSource\NewsArticle\HtmlSourceParserTemplate;
use AppBundle\Library\HypeSource\NewsArticle\NewsBTCParser;
use AppBundle\Library\HypeSource\NewsArticle\RssFeedParserInterface;
use AppBundle\Library\HypeSource\NewsArticle\RssFeedParserTemplate;
use AppBundle\Repository\HypeSourceRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewsArticleExtractor
{
    /** @var  HtmlSourceParserTemplate */
    private $htmlSourceParseTemplate;

    /** @var  RssFeedParserTemplate */
    private $rssFeedParserTemplate;

    /** @var  HypeSourceRepository */
    private $hyperSourceRepository;

    /** @var  EntityManagerInterface */
    private $entityManger;

    /**
     * NewsArticleExtractor constructor.
     *
     * @param HtmlSourceParserTemplate $htmlSourceParseTemplate
     * @param RssFeedParserTemplate    $rssFeedParserTemplate
     * @param HypeSourceRepository     $hypeSourceRepository
     * @param EntityManagerInterface   $entityManager
     */
    public function __construct(
        HtmlSourceParserTemplate $htmlSourceParseTemplate,
        RssFeedParserTemplate $rssFeedParserTemplate,
        HypeSourceRepository $hypeSourceRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->htmlSourceParseTemplate = $htmlSourceParseTemplate;
        $this->rssFeedParserTemplate   = $rssFeedParserTemplate;
        $this->hyperSourceRepository   = $hypeSourceRepository;
        $this->entityManger            = $entityManager;
    }

    public function getSourceList()
    {
        return [
            //CoinTelegraphParser::SOURCE_NAME   => new CoinTelegraphParser(), getting 503's?
            CoinDeskParser::SOURCE_NAME        => new CoinDeskParser(),
            CryptoNewsParser::SOURCE_NAME      => new CryptoNewsParser(),
            CoinJournalParser::SOURCE_NAME     => new CoinJournalParser(),
            NewsBTCParser::SOURCE_NAME         => new NewsBTCParser(),
            BitcoinMagazineParser::SOURCE_NAME => new BitcoinMagazineParser(),
            CryptoNinjaParser::SOURCE_NAME     => new CryptoNinjaParser(),
            FinanceMagnatesParser::SOURCE_NAME => new FinanceMagnatesParser(),
            CryptoQuickNewsParser::SOURCE_NAME => new CryptoQuickNewsParser(),
            CoinNewsAsiaParser::SOURCE_NAME    => new CoinNewsAsiaParser(),


            // Don't work ATM @todo research a way to make these work
            //CryptoCoinsNewsParser::SOURCE_NAME => new CryptoCoinsNewsParser(), // gives 403 when curling feed
            //CryptoInsiderParser::SOURCE_NAME => new CryptoInsiderParser(),
        ];
    }

    /**
     * @return HypeSource[]
     */
    public function extractHypeSources()
    {
        /** @var HtmlSourceParserInterface $parser */
        foreach ($this->getSourceList() as $parser) {

            $fullHypeSources = [];
            if ($parser instanceof HtmlSourceParserInterface) {
                $fullHypeSources = $this->htmlSourceParseTemplate->getHypeSources($parser);
            } else if ($parser instanceof RssFeedParserInterface) {
                $fullHypeSources = $this->rssFeedParserTemplate->getHypeSources($parser);
            }

            $sources = $this->removeExistingSources($fullHypeSources);

            foreach ($sources as $s) {
                $this->entityManger->persist($s);
            }
        }

        $this->entityManger->flush();
    }

    /**
     * @param HypeSource[] $sources
     *
     * @return HypeSource[]
     */
    private function removeExistingSources(array $sources): array
    {
        $urls = array_map([$this, 'getSourceUrl'], $sources);

        $existingSources = $this->hyperSourceRepository->findBy(['url' => $urls]);

        $existingUrls = array_map([$this, 'getSourceUrl'], $existingSources);

        return array_filter($sources, function (HypeSource $source) use ($existingUrls) {
            return !in_array($source->getUrl(), $existingUrls);
        });
    }

    private function getSourceUrl(HypeSource $s)
    {
        return $s->getUrl();
    }
}
