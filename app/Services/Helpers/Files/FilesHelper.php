<?php

namespace App\Services\Helpers\Files;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class FilesHelper implements FilesHelperService
{
    private string $savingPath = 'files/';

    public const SAVING_DISK = 'public';

    public function setSavingPath(string $path): void
    {
        $this->savingPath = $path;
    }

    public function handleFileUpload($value, Model $model, string $attribute): ?string
    {
        $path = null;
        switch (true) {
            case is_uploaded_file($value):
                $fileName = uniqid();
                $extension = $value->getClientOriginalExtension();

                $value->storeAs($this->savingPath, $fileName . '.' . $extension, self::SAVING_DISK);
                $path = $this->savingPath . '/' . $fileName . '.' . $extension;

                break;
            case is_null($value) && $model->$attribute:
                $this->deleteFile(public_path('/storage' . $model->$attribute));
                break;
        }

        return $path;
    }

    private function deleteFile($path): void
    {
        try {
            unlink($path);
        } catch (\Exception $exception) {
            Log::error('file deleting failed with exception: ' . $exception->getMessage());
        }
    }
}
