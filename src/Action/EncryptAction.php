<?php

declare(strict_types=1);

namespace App\Action;

use App\Exception\CipherException;
use App\Service\CipherService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;

final class EncryptAction
{
    public function __construct(
        private readonly CipherService $cipherService,
    ) {
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     * @return Response
     * @throws \JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        // Retrieve the request parameters
        $data = $request->getParsedBody();
        $text = $data['text'] ?? throw new HttpBadRequestException($request, 'Text parameter is missing');
        $password = $data['password'] ?? throw new HttpBadRequestException($request, 'Password parameter is missing');

        try {
            $ciphertext = $this->cipherService->encrypt($text, $password);
        } catch (CipherException $e) {
            throw new HttpInternalServerErrorException($request, 'Unable to encrypt text', $e);
        }

        // Return the ciphertext as JSON
        $response->getBody()->write(json_encode(['ciphertext' => $ciphertext], JSON_THROW_ON_ERROR));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
