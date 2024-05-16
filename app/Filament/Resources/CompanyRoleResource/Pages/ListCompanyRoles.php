<?php

namespace App\Filament\Resources\CompanyRoleResource\Pages;

use App\Filament\Resources\CompanyRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyRoles extends ListRecords
{
    protected static ?string $title = 'Роли';
    protected static string $resource = CompanyRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
