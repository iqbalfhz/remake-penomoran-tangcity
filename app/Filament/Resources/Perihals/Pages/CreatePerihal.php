<?php

namespace App\Filament\Resources\Perihals\Pages;

use App\Filament\Resources\Perihals\PerihalResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePerihal extends CreateRecord
{
    protected static string $resource = PerihalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
