<?php

declare(strict_types=1);

namespace App\Action;

use App\Exception\CipherException;
use App\Service\CipherService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

final class DecryptAction
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
        $ciphertext = $data['ciphertext'] ?? throw new HttpBadRequestException($request, 'Ciphertext parameter is missing');
        $password = $data['password'] ?? throw new HttpBadRequestException($request, 'Password parameter is missing');

        try {
            $text = $this->cipherService->decrypt($ciphertext, $password);
        } catch (CipherException $e) {
            throw new HttpBadRequestException($request, 'Unable to decrypt text', $e);
        }

        // Return the original text as JSON
        $response->getBody()->write(json_encode(['text' => $text], JSON_THROW_ON_ERROR));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
