<?php

declare(strict_types=1);

namespace App\Renderer;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class ApiErrorRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        return json_encode([
            'error' => [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ],
        ], JSON_THROW_ON_ERROR);
    }
}
