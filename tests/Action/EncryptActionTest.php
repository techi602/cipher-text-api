<?php

declare(strict_types=1);

namespace App\Test\Action;

use App\Service\CipherService;
use App\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase;

class EncryptActionTest extends TestCase
{
    use AppTestTrait;

    public function testEncrypt(): void
    {
        $request = $this->createFormRequest(
            'POST',
            '/encrypt',
            [
                'text' => 'text',
                'password' => 'password',
            ]
        );
        $this->mock(CipherService::class)->method('encrypt')->willReturn('foo');

        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"ciphertext":"foo"}', (string) $response->getBody());
    }
}
