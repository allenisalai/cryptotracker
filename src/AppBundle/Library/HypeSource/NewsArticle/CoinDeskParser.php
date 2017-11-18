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

class CoinDeskParser implements HtmlSourceParserInterface
{
    const SOURCE_NAME = 'coin-desk';

    public function getSourceName(): string
    {
        return self::SOURCE_NAME;
    }

    public function getSourceUrl(): string
    {
        return "https://www.coindesk.com/";
    }

    public function getArticleList(Crawler $source): Crawler
    {
        return $source->filter('.article');
    }

    public function getArticleDom(Crawler $articleDom): Crawler
    {
        return $articleDom;
    }

    public function getArticleTitle(Crawler $articleDom): string
    {
        return trim($articleDom->filter( 'h3')->text());
    }

    public function getArticleUrl(Crawler $articleDom): string
    {
        return $articleDom->filter('a.fade')->attr('href');
    }

    public function getArticleDate(Crawler $articleDom): DateTime
    {
        return new DateTime($articleDom->filter('time')->attr('datetime'));
    }
}