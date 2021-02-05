<?php

namespace Changelog\Retrievers;

use Symfony\Component\DomCrawler\Crawler;

class ChangesRetriever extends AbstractRetriever
{
	/**
	 * @return array
	 */
	public function retrieve()
	{
		$changes = [];

		$sections = parent::retrieve();
		foreach ($sections as $section) {
			if (isset($section['section'])) {
				$changes[$section['section']] = $section['changes'];
			}
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

		if (!$key) {
			return [];
		}

		$lines = (new LineRetriever($node->nextAll()->first()->children('li')))->retrieve();

		return [
			'section' => $key,
			'changes' => $lines
		];
	}
} 
