<?php

declare(strict_types=1);

namespace HPT\Product;

use HPT\Output;

class ProductOutput implements Output {

    /**
     * 
     * @var array
     */
    private $data = [];

    public function addProductData(string $productCode, array $productData) {
	$this->data[$productCode]=$productData;
    }

    public function getJson(): string {
	return json_encode($this->data);
    }

}
