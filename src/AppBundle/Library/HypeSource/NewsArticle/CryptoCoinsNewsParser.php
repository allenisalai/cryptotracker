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

class CryptoCoinsNewsParser implements RssFeedParserInterface
{
    const SOURCE_NAME = 'crypto-coin-news';

    public function getSourceName(): string
    {
        return self::SOURCE_NAME;
    }

    public function getSourceUrl(): string
    {
        return "https://www.ccn.com/feed/";
    }

    public function getArticleList(Crawler $source): Crawler
    {
        return $source->filter('.grid-wrapper .post');
    }

    public function getArticleDom(Crawler $articleDom): Crawler
    {
        return $articleDom;
    }

    public function getArticleTitle(Crawler $articleDom): string
    {
        return $articleDom->filter('.entry-title')->text();
    }

    public function getArticleUrl(Crawler $articleDom): string
    {
        return $articleDom->filter('.entry-title a')->attr('href');
    }

    public function getArticleDate(Crawler $articleDom): DateTime
    {
        return new DateTime($articleDom->filter('.grid-date span.date')->text());
    }
}
