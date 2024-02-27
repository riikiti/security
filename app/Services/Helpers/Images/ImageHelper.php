<?php

namespace App\Services\Helpers\Images;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ImageHelper implements ImageHelperService
{
    private string $savingPath = 'images';

    public const DISK = 'public';

    public function setSavingPath(string $path): void
    {
        $this->savingPath = $path;
    }

    public function handleImageUpload($value, Model $model, string $attribute): ?string
    {
        $name = md5(Carbon::now()) . '_' . $value->getClientOriginalName();
        $path = Storage::disk(static::DISK)->putFileAs($this->savingPath, $value, $name);
        return $path;
    }


}
