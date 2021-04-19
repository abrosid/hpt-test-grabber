<?php

declare(strict_types=1);

namespace HPT\Product;

use HPT\Dispatcher;

class ProductDispatcher extends Dispatcher {

    /**
     * @var string
     */
    private $filename;

    /**
     * 
     * @var array
     */
    private $productCodes;

    public function __construct(string $filename, ProductGrabber $grabber, ProductOutput $output) {
	parent::__construct($grabber, $output);
	$this->filename = $filename;
    }

    public function getGrabber(): ProductGrabber {
	return parent::getGrabber();
    }

    public function getOutput(): ProductOutput {
	return parent::getOutput();
    }

    public function run(): string {

	if (\file_exists($this->filename)) {
	    $this->productCodes = file($this->filename, FILE_IGNORE_NEW_LINES);
	} else {
	    return "File not exists: " . $this->filename;
	}

	if (empty($this->productCodes))
	    return "File is empty: " . $this->filename;
	
	foreach ($this->productCodes as $code) {
	    
	    $price = $this->getGrabber()->getPrice($code);
	    $data["price"] = $price;
	    $this->getOutput()->addProductData($code, $data);
	}
	
	return parent::run();
    }

}
