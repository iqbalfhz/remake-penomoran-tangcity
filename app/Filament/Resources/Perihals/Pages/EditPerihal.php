<?php

namespace App\Filament\Resources\Perihals\Pages;

use App\Filament\Resources\Perihals\PerihalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPerihal extends EditRecord
{
    protected static string $resource = PerihalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
