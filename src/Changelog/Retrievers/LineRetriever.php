<?php

namespace Changelog\Retrievers;


use Symfony\Component\DomCrawler\Crawler;

class LineRetriever extends AbstractRetriever
{
	/**
	 * @param Crawler $node
	 *
	 * @return array
	 */
	protected function parse(Crawler $node)
	{
		return $node->html();
	}
}