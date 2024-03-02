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
        $this->cipher = env('CIPHER_TYPE', 'AES-256-CBC');
        $this->iv = substr(hash('sha256', env('CIPHER_IV', '123445123445123445123445')), 0, 16);
    }

    public function encrypt($values, string $password)
    {
        $this->password = hash('sha256', $password);
        switch (true) {
            case is_array($values):
                foreach ($values as $key => $value) {
                    $values[$key] = base64_encode(openssl_encrypt($value, $this->cipher, $this->password, 0, $this->iv));
                }
                break;
            default:
                $values = base64_encode(openssl_encrypt($values, $this->cipher, $this->password, 0, $this->iv));
                break;
        }
        return $values;
    }

    public function decrypt($values, string $password)
    {
        $this->password = hash('sha256', $password);
        switch (true) {
            case is_array($values):
                foreach ($values as $key => $value) {
                    $values[$key] = openssl_decrypt(base64_decode($value), $this->cipher, $this->password, 0, $this->iv);
                }
                break;
            default:
                $values = openssl_decrypt(base64_decode($values), $this->cipher, $this->password, 0, $this->iv);
                break;
        }
        return $values;
    }
}
