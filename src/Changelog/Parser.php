<?php

namespace Changelog;

use Michelf\Markdown;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
	/**
	 * @var Crawler
	 */
	protected $content;

	/**
	 * @var Array
	 */
	protected $releases;

	/**
	 * @param $content
	 */
	public function __construct($content)
	{
		$this->setContent($content);
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->content->filter('h1')->nextAll()->first()->html();
	}

	/**
	 * Retrieve all the releases from the change log
	 *
	 * @return array
	 */
	public function getReleases()
	{
		$this->releases = [];

		// Retrieve the different releases
		$this->content->filter('h2')->each(function ($item) {
			$item->nextAll()
				->filterXPath('h3[preceding-sibling::h2[1][.="'. $item->html() . '"]]')
				->each(function ($section) use (&$changes) {
					$key = strtolower($section->html());

					if (in_array($key, ['added', 'changed', 'removed', 'fixed', 'security', 'deprecated'])) {
                  		$section->nextAll()
							->first()
							->filter('li')
							->each(function ($item) use ($key, &$changes) {
                      			$changes[$key][] = $item->html();
						});
					}
			});

			$title = explode(' - ', $item->html());
			$release = [
				'name'    => $title[0],
				'date'    => $title[1],
				'changes' => $changes,
			];

			$this->releases[] = $release;
		});

		return $this->releases;
	}

	/**
	 * Create a json representation of a change log
	 *
	 * @return string
	 */
	public function toJson()
	{
		return json_encode([
			'description' => $this->getDescription(),
			'releases'    => $this->getReleases()
		]);
	}

	/**
	 *
	 * @param $value
	 */
	public function setContent($value)
	{
		$this->content = new Crawler(Markdown::defaultTransform($value));
	}
}
