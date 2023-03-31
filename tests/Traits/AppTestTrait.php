<?php

declare(strict_types=1);

namespace App\Test\Traits;

use App\Bootstrap;
use App\Factory\ContainerFactory;
use DI\ContainerBuilder;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Selective\TestTrait\Traits\ArrayTestTrait;
use Selective\TestTrait\Traits\ContainerTestTrait;
use Selective\TestTrait\Traits\HttpJsonTestTrait;
use Selective\TestTrait\Traits\HttpTestTrait;
use Selective\TestTrait\Traits\MockTestTrait;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;

/**
 * App Test Trait.
 */
trait AppTestTrait
{
    use ArrayTestTrait;
    use ContainerTestTrait;
    use HttpTestTrait;
    use HttpJsonTestTrait;
    use MockTestTrait;

    protected App $app;

    /**
     * Before each test.
     */
    protected function setUp(): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            ServerRequestFactoryInterface::class => fn () => new ServerRequestFactory(),
        ]);
        $this->setUpContainer($builder->build());
        /** @var Bootstrap $bootstrap */
        $bootstrap = $this->container->get(Bootstrap::class);
        $this->app = $bootstrap();
    }
}
