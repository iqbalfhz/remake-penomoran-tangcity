<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Departemen;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->helperText('Kosongkan jika tidak ingin mengubah password (saat edit). Minimal 8 karakter.'),
                Select::make('departemen_id')
                    ->label('Departemen')
                    ->options(Departemen::pluck('nama', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->required()
                    ->helperText('Pilih minimal satu role'),
            ]);
    }
}
