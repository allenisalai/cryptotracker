<?php

namespace AppBundle\Library\HypeSource\NewsArticle;

use Symfony\Component\DomCrawler\Crawler;
use DateTime;

interface HtmlSourceParserInterface
{
    /** @return string */
    public function getSourceName(): string;

    /** @return string */
    public function getSourceUrl(): string;

    /**
     * @param Crawler $source
     * @return Crawler A list of child nodes that are articles
     */
    public function getArticleList(Crawler $source): Crawler;

    /**
     * @param Crawler $articleDom
     * @return Crawler The smallest encompassing article dom element
     */
    public function getArticleDom(Crawler $articleDom): Crawler;

    /**
     * @param Crawler $articleDom
     * @return string
     */
    public function getArticleTitle(Crawler $articleDom): string;

    /**
     * @param Crawler $articleDom
     * @return string
     */
    public function getArticleUrl(Crawler $articleDom): string;

    /**
     * @param Crawler $articleDom
     * @return DateTime
     */
    public function getArticleDate(Crawler $articleDom): DateTime;
}