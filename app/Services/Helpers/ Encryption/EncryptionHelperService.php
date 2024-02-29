<?php

namespace App\Services\Helpers\Encryption;

use Illuminate\Database\Eloquent\Model;

interface EncryptionHelperService
{
    public function encrypt(string $value, string $password): ?string;

    public function decrypt(string $value, string $password): ?string;

}
