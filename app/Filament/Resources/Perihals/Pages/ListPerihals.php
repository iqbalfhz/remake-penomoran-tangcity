<?php

namespace App\Filament\Resources\Perihals\Pages;

use App\Filament\Resources\Perihals\PerihalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPerihals extends ListRecords
{
    protected static string $resource = PerihalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
