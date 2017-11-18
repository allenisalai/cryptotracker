<?php

namespace AppBundle\Library\HypeSource\NewsArticle;


use AppBundle\Entity\HypeSource;
use DateTime;
use DateTimeImmutable;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class HtmlSourceParserTemplate
{
    /** @var  Client */
    private $guzzleClient;

    /** @var Crawler */
    private $crawler;

    /**
     * HtmlSourceParserTemplate constructor.
     * @param Client $guzzleClient
     * @param Crawler $crawler
     */
    public function __construct(Client $guzzleClient, Crawler $crawler)
    {
        $this->guzzleClient = $guzzleClient;
        $this->crawler = $crawler;
    }

    /**
     * @param HtmlSourceParserInterface $htmlSourceParser
     * @return HypeSource[]
     */
    public function getHypeSources(HtmlSourceParserInterface $htmlSourceParser): array
    {
        $html = (string)$this->guzzleClient->get($htmlSourceParser->getSourceUrl())->getBody();
        $this->crawler->clear();
        $this->crawler->add($html);

        $sources = [];
        $htmlSourceParser->getArticleList($this->crawler)->each(function (Crawler $node) use ($htmlSourceParser, &$sources) {
            $article = $htmlSourceParser->getArticleDom($node);

            $articleTitle = $htmlSourceParser->getArticleTitle($article);
            $articleUrl = $htmlSourceParser->getArticleUrl($article);
            $articleDate = $this->useExistingTimeAsPostingTime($htmlSourceParser->getArticleDate($article));

            $source = new HypeSource();
            $source
                ->setSource($htmlSourceParser->getSourceName())
                ->setTitle(trim($articleTitle))
                ->setUrl(($articleUrl))
                ->setPostingDate(DateTimeImmutable::createFromMutable($articleDate));


            $sources[] = $source;
        });

        return $sources;
    }

    /**
     * If the article date is today and the hour is midnight (assumed not set) then use the current time since we
     * should be polling for the articles regularly.
     *
     * @param DateTime $articleDate
     * @return DateTime
     */
    private function useExistingTimeAsPostingTime(DateTime $articleDate) : DateTime
    {
        $now = new DateTime();
        if ($now->format('Y-m-d') == $articleDate->format('Y-m-d') && $articleDate->format('H:i') == "00:00") {
            $articleDate = $now;
        }

        return $articleDate;
    }
}