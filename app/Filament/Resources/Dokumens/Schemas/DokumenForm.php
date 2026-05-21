<?php

namespace App\Filament\Resources\Dokumens\Schemas;

use App\Models\Departemen;
use App\Models\Dokumen;
use App\Models\JenisSurat;
use App\Models\Perihal;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DokumenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_surat_id')
                    ->label('Jenis Surat')
                    ->options(JenisSurat::pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn ($set) => $set('perihal', [])),

                Radio::make('kode_pt')
                    ->label('Perusahaan (PT)')
                    ->options([
                        'EFM'      => 'EFM',
                        'SSK'      => 'SSK',
                        'PAKAR'    => 'PAKAR',
                        'FIKA'     => 'FIKA',
                        'KOPERASI' => 'KOPERASI',
                    ])
                    ->required()
                    ->inline(),

                Select::make('departemen_id')
                    ->label('Departemen')
                    ->options(Departemen::pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->default(fn () => auth()->user()?->departemen_id)
                    ->disabled(fn () => ! auth()->user()?->hasRole('super_admin'))
                    ->dehydrated(),

                DatePicker::make('tanggal')
                    ->label('Tanggal Surat')
                    ->required()
                    ->default(now()),

                CheckboxList::make('perihal')
                    ->label('Perihal')
                    ->relationship('perihal', 'nama')
                    ->options(fn ($get) => Perihal::query()
                        ->where(function ($q) use ($get) {
                            $q->whereNull('jenis_surat_id');
                            if ($get('jenis_surat_id')) {
                                $q->orWhere('jenis_surat_id', $get('jenis_surat_id'));
                            }
                        })
                        ->pluck('nama', 'id')
                    )
                    ->columns(2)
                    ->required(),

                Textarea::make('keterangan')
                    ->label('Keterangan Tambahan')
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),

                TextInput::make('no_dokumen')
                    ->label('Nomor Dokumen')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Otomatis dibuat saat simpan'),
            ]);
    }
}
