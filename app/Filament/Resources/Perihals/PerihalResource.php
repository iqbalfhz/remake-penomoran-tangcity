<?php

namespace App\Filament\Resources\Perihals;

use App\Filament\Resources\Perihals\Pages\CreatePerihal;
use App\Filament\Resources\Perihals\Pages\EditPerihal;
use App\Filament\Resources\Perihals\Pages\ListPerihals;
use App\Filament\Resources\Perihals\Schemas\PerihalForm;
use App\Filament\Resources\Perihals\Tables\PerihalsTable;
use App\Models\Perihal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PerihalResource extends Resource
{
    protected static ?string $model = Perihal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?string $recordTitleAttribute = 'nama';

    protected static \UnitEnum|string|null $navigationGroup = 'Master Data';

    protected static ?string $modelLabel = 'Perihal';

    protected static ?string $pluralModelLabel = 'Perihal';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PerihalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerihalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPerihals::route('/'),
            'create' => CreatePerihal::route('/create'),
            'edit' => EditPerihal::route('/{record}/edit'),
        ];
    }
}
