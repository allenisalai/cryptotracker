<?php
/** @filesource */

namespace AppBundle\Library\HypeSource\NewsArticle;


use AppBundle\Entity\HypeSource;
use DateTimeImmutable;
use Eko\FeedBundle\Hydrator\HydratorInterface;
use Zend\Feed\Reader\Feed\FeedInterface;

class RssFeedHypeSourceHydrator implements HydratorInterface
{
    public function hydrate(FeedInterface $feed, $entityName)
    {
        $hypeSources = [];
        foreach ($feed as $entry) {
            $hypeSource = new HypeSource();
            $hypeSource->setTitle($entry->getTitle())
                       ->setPostingDate(DateTimeImmutable::createFromMutable( $entry->getDateCreated()))
                       ->setUrl($entry->getPermalink());
            $hypeSources[] = $hypeSource;
        }

        return $hypeSources;
    }
}
