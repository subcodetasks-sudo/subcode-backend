<?php

namespace App\Filament\Resources\Sectors;

use BackedEnum;
use App\Models\Sector;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\Sectors\Pages\EditSector;
use App\Filament\Resources\Sectors\Pages\ViewSector;
use App\Filament\Resources\Sectors\Pages\ListSectors;
use App\Filament\Resources\Sectors\Pages\CreateSector;
use App\Filament\Resources\Sectors\Schemas\SectorForm;
use App\Filament\Resources\Sectors\Tables\SectorsTable;
use App\Filament\Resources\Sectors\Schemas\SectorInfolist;

class SectorResource extends Resource
{
    protected static ?string $model = Sector::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

     public static function getNavigationLabel(): string
    {
        return __('strings.sectors');
    }

    public static function getModelLabel(): string
    {
        return __('strings.sector');
    }

    public static function getPluralModelLabel(): string
    {
        return __('strings.sectors');
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return SectorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SectorsTable::configure($table);
    }

   public static function infolist(Schema $schema): Schema
    {
        return SectorInfolist::configure($schema);
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
            'index' => ListSectors::route('/'),
            'create' => CreateSector::route('/create'),
            'edit' => EditSector::route('/{record}/edit'),
            'view' => ViewSector::route('/{record}'),

        ];
    }
}
