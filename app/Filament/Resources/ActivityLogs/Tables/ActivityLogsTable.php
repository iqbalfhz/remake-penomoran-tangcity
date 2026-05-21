<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('causer.name')
                    ->label('User')
                    ->placeholder('System')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Aktivitas')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn (?string $state) => $state
                        ? class_basename($state)
                        : '-'
                    )
                    ->badge()
                    ->color('gray'),
                TextColumn::make('log_name')
                    ->label('Log')
                    ->badge()
                    ->color('info'),
                TextColumn::make('event')
                    ->label('Event')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default   => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Filter Event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ]),
                SelectFilter::make('log_name')
                    ->label('Filter Log'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordActions([
                Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Perubahan')
                    ->modalDescription(fn ($record): string => match ($record->event) {
                        'updated' => 'Data akan dikembalikan ke nilai sebelum perubahan ini. Lanjutkan?',
                        'deleted' => 'Data yang dihapus akan dibuat ulang. Lanjutkan?',
                        default   => 'Tindakan ini tidak dapat di-restore.',
                    })
                    ->visible(fn ($record): bool => in_array($record->event, ['updated', 'deleted'])
                        && ! empty($record->subject_type)
                    )
                    ->action(function ($record): void {
                        $modelClass = $record->subject_type;

                        if ($record->event === 'updated') {
                            $oldValues = $record->properties['old'] ?? [];
                            if (empty($oldValues)) {
                                Notification::make()
                                    ->title('Tidak ada data lama untuk di-restore')
                                    ->warning()
                                    ->send();
                                return;
                            }
                            $subject = $modelClass::find($record->subject_id);
                            if (! $subject) {
                                Notification::make()
                                    ->title('Data tidak ditemukan')
                                    ->body('Record sudah dihapus dan tidak bisa di-restore via updated.')
                                    ->danger()
                                    ->send();
                                return;
                            }
                            $subject->updateQuietly($oldValues);

                        } elseif ($record->event === 'deleted') {
                            $attributes = $record->properties['attributes'] ?? [];
                            if (empty($attributes)) {
                                Notification::make()
                                    ->title('Tidak ada data untuk dibuat ulang')
                                    ->warning()
                                    ->send();
                                return;
                            }
                            $modelClass::create($attributes);
                        }

                        Notification::make()
                            ->title('Restore berhasil')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}

