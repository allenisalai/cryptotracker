<?php
/** @filesource */

namespace AppBundle\Library\HypeSource\NewsArticle;


interface RssFeedParserInterface
{
    public function getSourceName() : string;
    public function getSourceUrl() : string;
}
