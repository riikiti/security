<?php

namespace App\Filament\Resources\CompanyClustersResource\Pages;

use App\Filament\Resources\CompanyClustersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompanyClusters extends CreateRecord
{
    protected static string $resource = CompanyClustersResource::class;
    protected static ?string $title = 'Создание пользователя кластера компании';
}
