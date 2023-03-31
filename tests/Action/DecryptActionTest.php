<?php

declare(strict_types=1);

namespace App\Test\Action;

use App\Service\CipherService;
use App\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase;

class DecryptActionTest extends TestCase
{
    use AppTestTrait;

    public function testDecrypt(): void
    {
        $request = $this->createFormRequest(
            'POST',
            '/decrypt',
            [
                'ciphertext' => 'ciphertext',
                'password' => 'password',
            ]
        );
        $this->mock(CipherService::class)->method('decrypt')->willReturn('bar');

        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"text":"bar"}', (string) $response->getBody());
    }
}
