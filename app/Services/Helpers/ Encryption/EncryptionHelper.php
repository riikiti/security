<?php

namespace App\Services\Helpers\Encryption;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EncryptionHelper implements EncryptionHelperService
{

    private string $cipher;

    public function __construct()
    {
        $this->cipher = config('cipher.type');
    }

    public function encrypt(string $value, string $password): ?string
    {
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        return openssl_encrypt($value, $this->cipher, $password, $options = 0, $iv, $tag);
    }

    public function decrypt(string $value, string $password): ?string
    {
        return openssl_decrypt($value, $this->cipher, $password, $options = 0, $iv, $tag);
    }
}
