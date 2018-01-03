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

class CoinTelegraphParser implements RssFeedParserInterface
{
    const SOURCE_NAME = 'coin-telegraph';

    public function getSourceName(): string
    {
        return self::SOURCE_NAME;
    }

    public function getSourceUrl(): string
    {
        return "https://cointelegraph.com/feed";
    }
}
