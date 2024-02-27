<?php

namespace App\Services\Helpers\Files;

use Illuminate\Database\Eloquent\Model;

interface FilesHelperService
{
    public function handleFileUpload($value, Model $model, string $attribute): ?string;

    public function setSavingPath(string $path): void;
}
