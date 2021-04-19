<?php
// source: C:\jobtask\hpt-test-grabber/config.neon

/** @noinspection PhpParamsInspection,PhpMethodMayBeStaticInspection */

declare(strict_types=1);

class Container_dcca481015 extends Nette\DI\Container
{
	protected $types = ['container' => 'Nette\DI\Container'];
	protected $aliases = [];

	protected $wiring = [
		'Nette\DI\Container' => [['container']],
		'HPT\Grabber' => [['dispatcher']],
		'HPT\Product\ProductGrabber' => [['dispatcher']],
		'HPT\Output' => [['01']],
		'HPT\Product\ProductOutput' => [['01']],
		'HPT\Dispatcher' => [['02']],
		'HPT\Product\ProductDispatcher' => [['02']],
	];


	public function __construct(array $params = [])
	{
		parent::__construct($params);
		$this->parameters += [
			'filename' => 'vstup.txt',
			'searchUri' => 'https://www.czc.cz/|code|/hledat',
			'searchTerm' => '|code|',
			'filterPrice' => 'substring-before(substring-after(string(//div[@class=\'new-tile\']/@data-ga-impression), \'price":\'), \',"quantity\')',
		];
	}


	public function createService01(): HPT\Product\ProductOutput
	{
		return new HPT\Product\ProductOutput;
	}


	public function createService02(): HPT\Product\ProductDispatcher
	{
		return new HPT\Product\ProductDispatcher('vstup.txt', $this->getService('dispatcher'), $this->getService('01'));
	}


	public function createServiceContainer(): Container_dcca481015
	{
		return $this;
	}


	public function createServiceDispatcher(): HPT\Product\ProductGrabber
	{
		$service = new HPT\Product\ProductGrabber('https://www.czc.cz/|code|/hledat', '|code|');
		$service->setFilterPrice('substring-before(substring-after(string(//div[@class=\'new-tile\']/@data-ga-impression), \'price":\'), \',"quantity\')');
		return $service;
	}


	public function initialize()
	{
	}
}
