<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClusterResource\Pages;
use App\Filament\Resources\ClusterResource\RelationManagers;
use App\Models\Cluster;
use App\Models\Company;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClusterResource extends Resource
{
    protected static ?string $model = Cluster::class;
    protected static ?string $navigationLabel = 'Кластеры';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Кластер')->schema([
                    TextInput::make('name')->label('Название')->required()->maxValue(64)
                        ->disabled(),
                    TextInput::make('password')->label('Пароль')->required()->maxValue(64)
                        ->disabled(),
                    Select::make('user_id')
                        ->label('Пользователь')
                        ->options(User::all()->pluck('name', 'id'))
                        ->searchable(),
                    Select::make('company_id')
                        ->options(
                            Company::all()
                                ->pluck('name', 'id')
                        )
                        ->label('Компания'),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('id')->searchable(),
                TextColumn::make('name')->label('Название')->searchable(),
                TextColumn::make('user.email')->label('Пользователь')->searchable(),
                TextColumn::make('company.name')->label('Компания')->searchable(),
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
            RelationManagers\RecordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClusters::route('/'),
            'edit' => Pages\EditCluster::route('/{record}/edit'),
        ];
    }
}
