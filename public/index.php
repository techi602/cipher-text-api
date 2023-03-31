<?php

declare(strict_types=1);

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$container = $builder->build();
$app = $container->get(Bootstrap::class)();
$app->run();
