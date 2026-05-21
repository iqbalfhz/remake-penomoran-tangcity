<?php

namespace App\Filament\Resources\Departemens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepartemenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->label('Kode Departemen')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true)
                    ->helperText('Contoh: IT, ACCT, HR'),
                TextInput::make('nama')
                    ->label('Nama Departemen')
                    ->required()
                    ->maxLength(100),
            ]);
    }
}
