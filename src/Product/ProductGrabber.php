<?php

declare(strict_types=1);

namespace HPT\Product;

use HPT\Grabber;
use Symfony\Component\DomCrawler\Crawler;

class ProductGrabber implements Grabber
{
    /**
     * @var string
     */
    private $searchTerm;

    /**
     * @var string
     */
    private $searchUri;

    /**
     * @var string
     */
    private $filterPrice;

    /**
     * @var string
     */
    private $filterRating;

    /**
     * @var string
     */
    private $filterName;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $uri;

    public function __construct(string $searchUri, string $searchTerm)
    {
        $this->searchUri = $searchUri;
        $this->searchTerm = $searchTerm;
    }

    public function getFilterPrice(): string
    {
        return $this->filterPrice;
    }

    public function setFilterPrice(string $filterPrice): void
    {
        $this->filterPrice = $filterPrice;
    }

    public function getFilterRating(): string
    {
        return $this->filterRating;
    }

    public function setFilterRating(string $filterRating): void
    {
        $this->filterRating = $filterRating;
    }

    public function getFilterName()
    {
        return $this->filterName;
    }

    public function setFilterName($filterName): void
    {
        $this->filterName = $filterName;
    }

    public function getPrice(string $productId): ?float
    {
        $crawler = new Crawler($this->getContent($productId));
        $results = $crawler->evaluate($this->getFilterPrice());
        if ($results && !empty($results[0])) {
            return (float) $results[0];
        }

        return null;
    }

    public function getRating(string $productId): ?float
    {
        $crawler = new Crawler($this->getContent($productId));
        $results = $crawler->evaluate($this->getFilterRating());

        if ($results && !empty($results[0])) {
            return (float) $results[0];
        }

        return null;
    }

    public function getName(string $productId): ?string
    {
        $crawler = new Crawler($this->getContent($productId));
        $results = $crawler->evaluate($this->getFilterName());

        if ($results && !empty($results[0])) {
            return $results[0];
        }

        return null;
    }

    private function fetchUri(string $uri): string
    {
        $content = @\file_get_contents($uri);

        return $content ? $content : "<html></html>";
    }

    function getContent(string $productId): string
    {
        $uri = \str_replace($this->searchTerm, $productId, $this->searchUri);
        if ($this->uri != $uri) {
            $this->uri = $uri;
            $this->content = $this->fetchUri($this->uri);
        }

        return $this->content;
    }
}
