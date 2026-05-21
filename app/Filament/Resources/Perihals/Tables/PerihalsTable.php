<?php

namespace App\Filament\Resources\Perihals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PerihalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Perihal')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->placeholder('Semua jenis surat')
                    ->badge()
                    ->color(fn ($record) => $record->jenisSurat?->warna ?? 'gray'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis_surat_id')
                    ->label('Filter Jenis Surat')
                    ->relationship('jenisSurat', 'nama'),
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
