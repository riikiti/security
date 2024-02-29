<?php

namespace App\Services\Helpers\Encryption;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EncryptionHelper implements EncryptionHelperService
{

    private string $cipher;
    private string $iv;
    private string $password;

    public function __construct()
    {
        $this->cipher = hash('sha256', config('cipher.type'));
        $this->iv = substr(hash('sha256', config('cipher.iv')), 0, 16);
    }

    public function encrypt(string $value, string $password): ?string
    {
        $this->password = hash('sha256', $password);
        return base64_encode(openssl_encrypt($value, $this->cipher, $this->password, 0, $this->iv));
    }

    public function decrypt(string $value, string $password): ?string
    {
        $this->password = hash('sha256', $password);
        return openssl_decrypt(base64_decode($value), $this->cipher, $this->password, 0, $this->iv);
    }
}
