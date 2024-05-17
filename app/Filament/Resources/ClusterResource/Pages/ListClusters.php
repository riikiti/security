<?php

namespace App\Filament\Resources\ClusterResource\Pages;

use App\Filament\Resources\ClusterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClusters extends ListRecords
{
    protected static string $resource = ClusterResource::class;

    protected static ?string $title = 'Кластеры';

}
