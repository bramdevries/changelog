<?php

namespace Changelog\Retrievers;

use Symfony\Component\DomCrawler\Crawler;

class ReleasesRetriever extends AbstractRetriever
{
    /**
     * @param Crawler $node
     *
     * @return array
     */
    protected function parse(Crawler $node)
    {
        $title = explode(' - ', $node->html());

        // Get the changes
        $nodes = $node->nextAll()->filterXPath('h3[preceding-sibling::h2[1][.="'.$node->html().'"]]');

        $changes = (new ChangesRetriever($nodes))->retrieve();

        return [
            'name' => $title[0],
            'date' => isset($title[1]) ? $title[1] : null,
            'changes' => $changes,
        ];
    }
} 