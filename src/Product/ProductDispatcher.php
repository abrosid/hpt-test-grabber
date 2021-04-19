<?php

declare(strict_types=1);

namespace HPT\Product;

use HPT\Dispatcher;

class ProductDispatcher extends Dispatcher
{
	/**
	 * @var string
	 */
	private $filename;

	/**
	 * @var array
	 */
	private $productCodes;

	public function __construct(string $filename, ProductGrabber $grabber, ProductOutput $output)
	{
		$this->filename = $filename;
		$this->productCodes = [];
	
		parent::__construct($grabber, $output);
	}

	public function getGrabber(): ProductGrabber
	{
		return $this->grabber;
	}

	public function getOutput(): ProductOutput
	{
		return $this->output;
	}

	public function run(): string
	{
		if (\file_exists($this->filename)) {
			$this->productCodes = file($this->filename, FILE_IGNORE_NEW_LINES);
		} else {
			return "File not exists: " . $this->filename;
		}

		if (empty($this->productCodes)) {
			return "No product codes in the file: " . $this->filename;
		}

		foreach ($this->productCodes as $code) {
			$data["price"] = $this->getGrabber()->getPrice($code);
			$data["name"] = $this->getGrabber()->getName($code);
			$data["rating"] = $this->getGrabber()->getRating($code);

			$this->getOutput()->addProductData($code, $data);
		}

		return parent::run();
	}
}
