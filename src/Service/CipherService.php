<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\CipherException;

class CipherService
{
    private const CIPHER_ALGO = 'aes-256-ecb';

    /**
     * @throws CipherException
     */
    public function encrypt(string $text, string $password): string
    {
        $cipherRawData = openssl_encrypt(
            $text,
            self::CIPHER_ALGO,
            $password,
            OPENSSL_RAW_DATA
        );
        if ($cipherRawData === false) {
            throw new CipherException('Unable to encrypt data');
        }

        return base64_encode($cipherRawData);
    }

    /**
     * @throws CipherException
     */
    public function decrypt(string $cipherText, string $password): string
    {
        $cipherRawData = base64_decode($cipherText);
        if ($cipherRawData === false) {
            throw new CipherException('Unable to decrypt data');
        }
        $text = openssl_decrypt(
            $cipherRawData,
            self::CIPHER_ALGO,
            $password,
            OPENSSL_RAW_DATA,
        );
        if ($text === false) {
            throw new CipherException('Unable to decrypt data');
        }

        return $text;
    }
}
