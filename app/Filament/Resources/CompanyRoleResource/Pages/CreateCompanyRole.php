<?php

namespace App\Filament\Resources\CompanyRoleResource\Pages;

use App\Filament\Resources\CompanyRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompanyRole extends CreateRecord
{
    protected static ?string $title = 'Роли';
    protected static string $resource = CompanyRoleResource::class;
}
