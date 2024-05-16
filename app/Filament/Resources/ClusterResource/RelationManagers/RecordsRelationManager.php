<?php

namespace App\Filament\Resources\ClusterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Rawilk\FilamentPasswordInput\Password;

class RecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'records';
    protected static ?string $title = 'Записи кластера';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Название записи')
                            ->maxLength(255),
                        ColorPicker::make('color')->label('Цвет'),

                        Forms\Components\TextInput::make('site')
                            ->label('Сайт')
                            ->maxLength(255)
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label('Почта')
                            ->maxLength(255)
                            ->disabled(),
                        Forms\Components\TextInput::make('login')
                            ->label('Логин')
                            ->maxLength(255)
                            ->disabled(),
                        Password::make('password')
                            ->label('Пароль')
                            ->maxLength(255)
                            ->disabled(),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('id'),
                Tables\Columns\TextColumn::make('title')->label('Запись'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
