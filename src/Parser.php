<?php

namespace Changelog;

use Changelog\Retrievers\ChangesRetriever;
use Changelog\Retrievers\DescriptionRetriever;
use Changelog\Retrievers\ReleasesRetriever;
use League\CommonMark\CommonMarkConverter;
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
     * @param $content
     */
    public function __construct($content)
    {
        $this->setContent($content);
    }

    /**
     * Retrieve all the releases from the change log
     *
     * @return array
     */
    public function getReleases()
    {
        return (new ReleasesRetriever($this->content->filter('h2')))->retrieve();
    }

    /**
     * @return array|void
     */
    public function getChanges()
    {
        return (new ChangesRetriever($this->content->filter('h3')))->retrieve();
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
     * @return string
     */
    public function getDescription()
    {
        return (new DescriptionRetriever($this->content->filter('h1 ~ p')))->retrieve();
    }
}
