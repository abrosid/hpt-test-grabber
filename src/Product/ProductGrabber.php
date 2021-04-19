<?php

declare(strict_types=1);

namespace HPT\Product;

use HPT\Grabber;
use Symfony\Component\DomCrawler\Crawler;

class ProductGrabber implements Grabber {

    const  _filterPrice="substring-before(substring-after(string(//div[@class='new-tile']/@data-ga-impression), 'price\":'), ',\"quantity')";
   

    /**
     * @var string
     */
    private $searchTerm;

    /**
     * @var string
     */
    private $searchUri;
    
    /**
     * 
     * @var string
     */
    private $filterPrice;

    public function getFilterPrice(): string {
	return $this->filterPrice;
    }

    public function setFilterPrice(string $filterPrice): void {
	$this->filterPrice = $filterPrice;
    }

    
    public function __construct(string $searchUri, string $searchTerm) {
	$this->searchUri = $searchUri;
	$this->searchTerm = $searchTerm;
    }

    
        
    
    public function getPrice(string $productId): float {
	$uri = \str_replace($this->searchTerm, $productId, $this->searchUri);
	$content = $this->fetchUri($uri);
	$crawler = new Crawler($content);
	
	$results = $crawler->evaluate($this->getFilterPrice());
	if ($results && !empty($results[0])) {
	    return (float) $results[0];
	}
	return 0.0;
    }

    private function fetchUri(string $uri) {
	$content = @\file_get_contents($uri);
	return $content ? $content : "<html></html>";
    }

}
