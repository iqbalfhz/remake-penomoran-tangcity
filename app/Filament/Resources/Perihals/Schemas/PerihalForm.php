<?php

namespace App\Filament\Resources\Perihals\Schemas;

use App\Models\JenisSurat;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PerihalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Perihal')
                    ->required()
                    ->maxLength(150),
                Select::make('jenis_surat_id')
                    ->label('Jenis Surat (Opsional)')
                    ->options(JenisSurat::pluck('nama', 'id'))
                    ->placeholder('Berlaku untuk semua jenis surat')
                    ->nullable()
                    ->helperText('Kosongkan jika perihal berlaku untuk semua jenis surat'),
            ]);
    }
}
