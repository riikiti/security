<?php

namespace App\Filament\Resources\CompanyRoleResource\Pages;

use App\Filament\Resources\CompanyRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyRole extends EditRecord
{
    protected static ?string $title = 'Роли';
    protected static string $resource = CompanyRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
