<?php

namespace AppBundle\Library\HypeSource;


use AppBundle\Entity\HypeSource;
use AppBundle\Library\HypeSource\NewsArticle\CoinDeskParser;
use AppBundle\Library\HypeSource\NewsArticle\CoinTelegraphParser;
use AppBundle\Library\HypeSource\NewsArticle\CryptoCoinsNewsParser;
use AppBundle\Library\HypeSource\NewsArticle\CryptoInsiderParser;
use AppBundle\Library\HypeSource\NewsArticle\HtmlSourceParserInterface;
use AppBundle\Library\HypeSource\NewsArticle\HtmlSourceParserTemplate;
use AppBundle\Repository\HypeSourceRepository;
use Doctrine\ORM\EntityManager;

class NewsArticleExtractor
{
    /** @var  HtmlSourceParserTemplate */
    private $htmlSourceParseTemplate;

    /** @var  HypeSourceRepository */
    private $hyperSourceRepository;

    /** @var  EntityManager */
    private $entityManger;

    /**
     * NewsArticleExtractor constructor.
     *
     * @param HtmlSourceParserTemplate $htmlSourceParseTemplate
     * @param HypeSourceRepository $hypeSourceRepository
     * @param EntityManager $entityManager
     */
    public function __construct(
        HtmlSourceParserTemplate $htmlSourceParseTemplate,
        HypeSourceRepository $hypeSourceRepository,
        EntityManager $entityManager)
    {
        $this->htmlSourceParseTemplate = $htmlSourceParseTemplate;
        $this->hyperSourceRepository = $hypeSourceRepository;
        $this->entityManger = $entityManager;
    }

    public function getSourceList()
    {
        return [
            CoinDeskParser::SOURCE_NAME => new CoinDeskParser(),
            CoinTelegraphParser::SOURCE_NAME => new CoinTelegraphParser(),
            CryptoCoinsNewsParser::SOURCE_NAME => new CryptoCoinsNewsParser(),
            CryptoInsiderParser::SOURCE_NAME => new CryptoInsiderParser(),
        ];
    }

    /**
     * @return HypeSource[]
     */
    public function extractHypeSources()
    {
        /** @var HtmlSourceParserInterface $parser */
        foreach ($this->getSourceList() as $parser) {
            $sources = $this->removeExistingSources($this->htmlSourceParseTemplate->getHypeSources($parser));

            foreach ($sources as $s){
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