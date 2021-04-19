<?php

declare(strict_types=1);

use HPT\Product\ProductDispatcher;
use Nette\DI\ContainerLoader;

require_once __DIR__ . '/vendor/autoload.php';

if (PHP_SAPI !== 'cli') {
    echo 'This script must be run from CLI.';

    exit(1);
}

$loader = new ContainerLoader(__DIR__ . '/temp', true);
$class = $loader->load(function ($compiler) {
    $compiler->loadConfig(__DIR__ . '/config.neon');
});
$container = new $class;

/**
 * @var ProductDispatcher
 */
$dispatcher = $container->getByType(ProductDispatcher::class);

echo $dispatcher->run();
