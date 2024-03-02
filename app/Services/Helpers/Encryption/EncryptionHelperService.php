<?php

namespace App\Services\Helpers\Encryption;

use Illuminate\Database\Eloquent\Model;

interface EncryptionHelperService
{
    public function encrypt($values, string $password);

    public function decrypt( $values, string $password);

}
