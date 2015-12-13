<?php

namespace Changelog\Retrievers;

use Symfony\Component\DomCrawler\Crawler;

class DescriptionRetriever extends AbstractRetriever
{
    /**
     * @return null|string
     */
    public function retrieve()
    {
        $items = parent::retrieve();

        if (!$items) {
            return null;
        }

        return implode(PHP_EOL.PHP_EOL, $items);
    }

    /**
     * @param Crawler $node
     *
     * @return string
     */
    protected function parse(Crawler $node)
    {
        return $node->text();
    }
}