<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class StatsUserChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Новые пользователи по месяцам';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $users = $this->getUsersPerMonth();
        return [
            'datasets' => [
                [
                    'label' => 'Новые пользователи',
                    'data' => $users['usersPerMonth']
                ],
            ],
            'labels' => $users['months']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getUsersPerMonth(): array
    {
        $now = Carbon::now();
        $usersPerMonth = [];
        $months = collect(range(1, 12))->map(function ($month) use ($now, &$usersPerMonth) {
            $count = User::whereMonth('created_at', Carbon::parse($now->month($month)->format('Y-m')))->count();
            $usersPerMonth[] = $count;
            return $now->month($month)->translatedFormat('M');
        })->toArray();
        return [
            'usersPerMonth' => $usersPerMonth,
            'months' => $months
        ];
    }
}
