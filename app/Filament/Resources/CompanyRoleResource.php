<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyRoleResource\Pages;
use App\Filament\Resources\CompanyRoleResource\RelationManagers;
use App\Models\Company;
use App\Models\CompanyRole;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyRoleResource extends Resource
{
    protected static ?string $model = CompanyRole::class;
    protected static ?string $navigationLabel = 'Роли';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        TextInput::make('role')->label('Роль')->required(),
                        Select::make('company_id')->options(Company::all()->pluck('name', 'id'))->label('Компания'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('id'),
                TextColumn::make('role')->label('Роль'),
                TextColumn::make('company.name')->label('Компания'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyRoles::route('/'),
            'create' => Pages\CreateCompanyRole::route('/create'),
            'edit' => Pages\EditCompanyRole::route('/{record}/edit'),
        ];
    }
}
