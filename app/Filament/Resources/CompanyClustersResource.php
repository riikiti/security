<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyClustersResource\Pages;
use App\Filament\Resources\CompanyClustersResource\RelationManagers;
use App\Models\Cluster;
use App\Models\Company;
use App\Models\CompanyClusters;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyClustersResource extends Resource
{
    protected static ?string $model = CompanyClusters::class;

    protected static ?string $navigationLabel = 'Пользователи кластеров';
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                Select::make('cluster_id')
                    ->options(
                        Cluster::query()->where('company_id','!=',null)
                            ->pluck('name', 'id')
                    )
                    ->label('Компания'),
                Select::make('user_id')
                    ->label('Пользователь')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
                Checkbox::make('is_redactor')->label('Редактирование'),
                Checkbox::make('is_reader')->label('Чтение'),
                Checkbox::make('is_inviter')->label('Приглашения'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('id')->searchable(),
                TextColumn::make('cluster.company.name')->label('Компания')->searchable(),
                TextColumn::make('user.email')->label('Пользователь')->searchable(),
                TextColumn::make('cluster.name')->label('Кластер')->searchable(),
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
            'index' => Pages\ListCompanyClusters::route('/'),
            'create' => Pages\CreateCompanyClusters::route('/create'),
            'edit' => Pages\EditCompanyClusters::route('/{record}/edit'),
        ];
    }
}
