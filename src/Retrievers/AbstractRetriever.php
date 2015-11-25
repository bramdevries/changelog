<?php

namespace Changelog\Retrievers;


use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractRetriever
{
	/**
	 * @var array
	 */
	protected $nodes;

	/**
	 * @param Crawler $nodes
	 */
	public function __construct(Crawler $nodes)
	{
		$this->nodes = [];
		$nodes->each(function ($node) {
			$this->nodes[] = $node;
		});
	}

	/**
	 * @return array
	 */
	public function retrieve()
	{
		return array_map([$this, 'parse'], $this->nodes);
	}

	/**
	 * @param Crawler $node
	 */
	abstract protected function parse(Crawler $node);
} 