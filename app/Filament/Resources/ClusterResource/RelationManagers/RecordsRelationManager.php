<?php

namespace App\Filament\Resources\ClusterResource\RelationManagers;

use Filament\Forms;
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
                        Forms\Components\TextInput::make('site')
                            ->label('Сайт')
                            ->required()
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Почта')
                            ->required()
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('login')
                            ->label('Логин')
                            ->maxLength(255),
                        Password::make('password')
                            ->label('Пароль')
                            ->required()
                            ->maxLength(255),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('id'),
                Tables\Columns\TextColumn::make('site')->label('Сайт'),
                Tables\Columns\TextColumn::make('email')->label('Почта'),
                Tables\Columns\TextColumn::make('login')->label('Логин'),
                Tables\Columns\TextColumn::make('password')->label('Пароль'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
