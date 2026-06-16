<?php

namespace App\Filament\Resources\Occasions;

use App\Filament\Resources\Occasions\Pages\CreateOccasion;
use App\Filament\Resources\Occasions\Pages\EditOccasion;
use App\Filament\Resources\Occasions\Pages\ListOccasions;
use App\Filament\Resources\Occasions\Schemas\OccasionForm;
use App\Filament\Resources\Occasions\Schemas\OccasionInfolist;
use App\Filament\Resources\Occasions\Tables\OccasionsTable;
use App\Models\Occasion;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;

class OccasionResource extends Resource
{
    protected static ?string $model = Occasion::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

     public static function getNavigationLabel(): string
    {
        return __('strings.occasions');
    }

    public static function getModelLabel(): string
    {
        return __('strings.occasion');
    }

    public static function getPluralModelLabel(): string
    {
        return __('strings.occasions');
    }

   

     public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return OccasionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OccasionsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OccasionInfolist::configure($schema);
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
            'index' => ListOccasions::route('/'),
            'create' => CreateOccasion::route('/create'),
            'edit' => EditOccasion::route('/{record}/edit'),
        ];
    }
}
