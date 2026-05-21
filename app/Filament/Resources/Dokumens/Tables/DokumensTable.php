<?php

namespace App\Filament\Resources\Dokumens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DokumensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('no_dokumen')
                    ->label('Nomor Dokumen')
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->fontFamily('mono'),
                TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color(fn ($record) => $record->jenisSurat?->warna ?? 'primary')
                    ->searchable(),
                TextColumn::make('kode_pt')
                    ->label('PT')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('departemen.nama')
                    ->label('Departemen')
                    ->searchable(),
                TextColumn::make('perihal.nama')
                    ->label('Perihal')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->searchable(),
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Dibuat Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Waktu Input')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis_surat_id')
                    ->label('Jenis Surat')
                    ->relationship('jenisSurat', 'nama'),
                SelectFilter::make('kode_pt')
                    ->label('PT')
                    ->options([
                        'EFM'      => 'EFM',
                        'SSK'      => 'SSK',
                        'PAKAR'    => 'PAKAR',
                        'FIKA'     => 'FIKA',
                        'KOPERASI' => 'KOPERASI',
                    ]),
                SelectFilter::make('departemen_id')
                    ->label('Departemen')
                    ->relationship('departemen', 'nama'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
