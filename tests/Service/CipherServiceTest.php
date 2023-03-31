<?php

declare(strict_types=1);

namespace App\Test\Service;

use App\Exception\CipherException;
use App\Service\CipherService;
use PHPUnit\Framework\TestCase;

class CipherServiceTest extends TestCase
{
    private CipherService $cipherService;

    public function setUp(): void
    {
        $this->cipherService = new CipherService();
    }

    public function testEncrypt(): void
    {
        $this->assertSame('65iWpwbF709RPkjiUlW5G/7q+zJuJwEROmSf6ymnBHM=', $this->cipherService->encrypt('some random text', 'topSecretPassword'));
    }

    public function testDecrypt(): void
    {
        $this->assertSame('some random text', $this->cipherService->decrypt('65iWpwbF709RPkjiUlW5G/7q+zJuJwEROmSf6ymnBHM=', 'topSecretPassword'));
    }

    public function testDecryptFailure(): void
    {
        $this->expectException(CipherException::class);
        $this->cipherService->decrypt('invalid cypher text', 'topSecretPassword');
    }
}
