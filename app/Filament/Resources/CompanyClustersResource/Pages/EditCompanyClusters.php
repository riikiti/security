<?php

namespace App\Filament\Resources\CompanyClustersResource\Pages;

use App\Filament\Resources\CompanyClustersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyClusters extends EditRecord
{
    protected static string $resource = CompanyClustersResource::class;
    protected static ?string $title = 'Редактирование пользователей кластеров компании';
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
