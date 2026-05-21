<?php

namespace App\Filament\Resources\JenisSurats;

use App\Filament\Resources\JenisSurats\Pages\CreateJenisSurat;
use App\Filament\Resources\JenisSurats\Pages\EditJenisSurat;
use App\Filament\Resources\JenisSurats\Pages\ListJenisSurats;
use App\Filament\Resources\JenisSurats\Schemas\JenisSuratForm;
use App\Filament\Resources\JenisSurats\Tables\JenisSuratsTable;
use App\Models\JenisSurat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JenisSuratResource extends Resource
{
    protected static ?string $model = JenisSurat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'nama';

    protected static \UnitEnum|string|null $navigationGroup = 'Master Data';

    protected static ?string $modelLabel = 'Jenis Surat';

    protected static ?string $pluralModelLabel = 'Jenis Surat';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return JenisSuratForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisSuratsTable::configure($table);
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
            'index' => ListJenisSurats::route('/'),
            'create' => CreateJenisSurat::route('/create'),
            'edit' => EditJenisSurat::route('/{record}/edit'),
        ];
    }
}
