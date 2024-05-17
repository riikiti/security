<?php

namespace App\Filament\Resources\CompanyClustersResource\Pages;

use App\Filament\Resources\CompanyClustersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyClusters extends ListRecords
{
    protected static string $resource = CompanyClustersResource::class;

    protected static ?string $title = 'Пользователи кластеров компании';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
