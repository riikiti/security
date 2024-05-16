<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsUsersWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('Всего пользователей', User::count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Всего пользователей в компаниях', User::query()->where('company_id', '!=', null)->count())
                ->color('success')
                ->chart([2, 3, 4, 7, 6, 3, 5, 3]),
            Stat::make('Всего пользователей без компании', User::query()->where('company_id', '=', null)->count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
