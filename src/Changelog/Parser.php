<?php

namespace Changelog;

use League\CommonMark\CommonMarkConverter;
use Michelf\Markdown;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
	/**
	 * @var array
	 */
	protected $sections = ['added', 'changed', 'removed', 'fixed', 'security', 'deprecated'];

	/**
	 * @var Crawler
	 */
	protected $content;

	/**
	 * @var Array
	 */
	protected $releases;

	/**
	 * @var Array
	 */
	protected $changes;

	/**
	 * The default methods to use to retrieve a change log
	 *
	 * @var array
	 */
	protected $defaults = [
		'method' => 'filter',
		'query'  => 'h3',
	];

	/**
	 * @param $content
	 */
	public function __construct($content)
	{
		$this->setContent($content);
	}

	/**
	 * Return the description of a change log
	 *
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
			$title = explode(' - ', $item->html());
			$release = [
				'name'    => $title[0],
				'date'    => $title[1],
				'changes' => $this->getChanges($item, false),
			];

			$this->releases[] = $release;
		});

		return $this->releases;
	}

	/**
	 * Retrieve a set of changes for a single release
	 *
	 * @param $release
	 * @param $json boolean
	 * @return array
	 */
	public function getChanges($release = null, $json = true)
	{
		$defaults = $this->defaults;

		$defaults['item'] = $this->content;

		// If an item is passed through (because the entire file is being parsed, set different options).
		if ($release) {
			$defaults['method'] = 'filterXPath';
			$defaults['query'] = 'h3[preceding-sibling::h2[1][.="' . $release->html() . '"]]';
			$defaults['item'] = $release->nextAll();
		}

		$this->changes = [];
		$defaults['item']->{$defaults['method']}($defaults['query'])
			->each(function ($section){
				$key = strtolower($section->html());

				if ($this->isAllowedSection($key)) {
					$section->nextAll()
						->first()
						->filter('li')
						->each(function ($item) use ($key) {
							$this->changes[$key][] = $item->html();
						});
				}
			});

		return $json ? json_encode($this->changes) : $this->changes;
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
	 * Set the content to parse
	 *
	 * @param $value
	 */
	public function setContent($value)
	{
		$converter = new CommonMarkConverter;
		$this->content = new Crawler($converter->convertToHtml($value));
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	private function isAllowedSection($key = null)
	{
		return in_array($key, $this->sections);
	}
}
