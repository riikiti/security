<?php

namespace App\Filament\Widgets;

use App\Models\Cluster;
use App\Models\Record;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsUsersClusterWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected function getStats(): array
    {
        return [
            Stat::make('Всего кластеров', Cluster::count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Всего записей в кластерах', Record::count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
