<?php

namespace AppBundle\Library\HypeSource\NewsArticle;


use AppBundle\Entity\HypeSource;
use DateTime;
use DateTimeImmutable;
use Eko\FeedBundle\Feed\Reader;
use Eko\FeedBundle\Hydrator\DefaultHydrator;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class RssFeedParserTemplate
{
    /** @var  Reader */
    private $reader;


    /**
     * HtmlSourceParserTemplate constructor.
     *
     * @param Reader $reader
     *
     * @internal param Crawler $crawler
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param RssFeedParserInterface $rssFeedParser
     *
     * @return array
     */
    public function getHypeSources(RssFeedParserInterface $rssFeedParser): array
    {
        $this->reader->setHydrator(new RssFeedHypeSourceHydrator());
        $sources = $this->reader->load($rssFeedParser->getSourceUrl())
                                ->populate('AppBundle\Entity\HypeSource');

        /** @var HypeSource $s */
        foreach ($sources as $s) {
            $s->setSource($rssFeedParser->getSourceName());
        }

        return $sources;
    }
}
