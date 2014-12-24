<?php

namespace Changelog\Retrievers;

use Symfony\Component\DomCrawler\Crawler;

class ChangesRetriever extends AbstractRetriever
{
	/**
	 * @return array|void
	 */
	public function retrieve()
	{
		$changes = [];

		$sections = parent::retrieve();
		foreach ($sections as $section) {
			$changes[$section['section']] = $section['changes'];
		}

		return $changes;
	}

	/**
	 * @param Crawler $node
	 *
	 * @return array
	 */
	protected function parse(Crawler $node)
	{
		$key = strtolower($node->html());

		$lines = (new LineRetriever($node->nextAll()->first()->filter('li')))->retrieve();

		return [
			'section' => $key,
			'changes' => $lines
		];
	}
} 