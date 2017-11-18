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

class CryptoInsiderParser implements HtmlSourceParserInterface
{
    const SOURCE_NAME = 'crypto-insider';

    public function getSourceName(): string
    {
        return self::SOURCE_NAME;
    }

    public function getSourceUrl(): string
    {
        return "https://cryptoinsider.com/category/news/";
    }

    public function getArticleList(Crawler $source): Crawler
    {
        return $source->filter('.paginated_content article');
    }

    public function getArticleDom(Crawler $articleDom): Crawler
    {
        return $articleDom;
    }

    public function getArticleTitle(Crawler $articleDom): string
    {
        return $articleDom->filter('.post-title')->text();
    }

    public function getArticleUrl(Crawler $articleDom): string
    {
        return $articleDom->filter('.post-title a')->attr('href');
    }

    public function getArticleDate(Crawler $articleDom): DateTime
    {
        return new DateTime($articleDom->filter('span.updated')->text());
    }
}