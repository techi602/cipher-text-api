<?php

declare(strict_types=1);

namespace App;

use App\Action\DecryptAction;
use App\Action\EncryptAction;
use App\Renderer\ApiErrorRenderer;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Handlers\ErrorHandler;

final class Bootstrap
{
    public function __construct(
        private readonly ContainerInterface $container,
    ) {
    }

    public function __invoke(): App
    {
        $app = AppFactory::createFromContainer($this->container);

        // Middleware to handle errors
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);

        // Force error response in json
        /** @var ErrorHandler $errorHandler */
        $errorHandler = $errorMiddleware->getDefaultErrorHandler();
        $errorHandler->registerErrorRenderer('application/json', ApiErrorRenderer::class);
        $errorHandler->forceContentType('application/json');

        // Endpoint for encrypting text
        $app->post('/encrypt', EncryptAction::class);

        // Endpoint for decrypting text
        $app->post('/decrypt', DecryptAction::class);

        return $app;
    }
}
