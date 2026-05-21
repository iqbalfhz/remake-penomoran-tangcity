<?php

namespace App\Filament\Resources\JenisSurats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JenisSuratForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->label('Kode Surat')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true)
                    ->helperText('Contoh: IM, SK, MOU'),
                TextInput::make('nama')
                    ->label('Nama Jenis Surat')
                    ->required()
                    ->maxLength(100),
                Select::make('warna')
                    ->label('Warna Badge')
                    ->options([
                        'primary'  => 'Primary (Biru)',
                        'success'  => 'Success (Hijau)',
                        'warning'  => 'Warning (Kuning)',
                        'danger'   => 'Danger (Merah)',
                        'info'     => 'Info (Cyan)',
                        'gray'     => 'Gray (Abu)',
                    ])
                    ->default('primary')
                    ->required(),
            ]);
    }
}
