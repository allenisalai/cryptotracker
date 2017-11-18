<?php
/**
 * Created by PhpStorm.
 * User: alai
 * Date: 9/3/17
 * Time: 4:39 PM
 */

namespace AppBundle\Library\HypeSource\NewsArticle;


use DateTime;
use Symfony\Component\DomCrawler\Crawler;

class CoinTelegraphParser implements HtmlSourceParserInterface
{
    const SOURCE_NAME = 'coin-telegraph';

    public function getSourceName(): string
    {
        return self::SOURCE_NAME;
    }

    public function getSourceUrl(): string
    {
        return "https://cointelegraph.com/";
    }

    public function getArticleList(Crawler $source): Crawler
    {
        return $source->filter('#posts-content .post');
    }

    public function getArticleDom(Crawler $articleDom): Crawler
    {
        return $articleDom;
    }

    public function getArticleTitle(Crawler $articleDom): string
    {
        return $articleDom->filter('.postTitle')->text();
    }

    public function getArticleUrl(Crawler $articleDom): string
    {
        return $articleDom->filter('a')->attr('href');
    }

    public function getArticleDate(Crawler $articleDom): DateTime
    {
        return new DateTime($articleDom->filter('.info span.date')->text());
    }
}