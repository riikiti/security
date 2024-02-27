<?php

namespace App\Services\Helpers\Images;

use Illuminate\Database\Eloquent\Model;

interface ImageHelperService
{
    public function handleImageUpload($value, Model $model, string $attribute): ?string;

    public function setSavingPath(string $path): void;
}
