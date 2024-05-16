<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class StatsUserChartMonthWidget extends ChartWidget
{
    protected static ?int $sort = 1;

    public function getHeading(): string
    {
        return "Новые пользователи за " . Carbon::now()->translatedFormat('F');
    }

    protected function getData(): array
    {
        $amounts = $this->getTransactionPerMonth();
        return [
            'datasets' => [
                [
                    'label' => 'Пользователи',
                    'data' => $amounts['userCountsByDay']
                ],
            ],
            'labels' => $amounts['daysInMonth']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getTransactionPerMonth(): array
    {
        $now = Carbon::now();
        $userCountsByDay = [];
        $daysInMonth = collect(range(1, $now->endOfMonth()->day))->map(function ($day) use ($now, &$userCountsByDay) {
            $date = $now->day($day);
            $userCount = User::whereDate('created_at', $date->format('Y-m-d'))->count();
            $userCountsByDay[] = $userCount;
            return $date->translatedFormat('d');
        })->toArray();
        return [
            'userCountsByDay' => $userCountsByDay,
            'daysInMonth' => $daysInMonth
        ];
    }
}
