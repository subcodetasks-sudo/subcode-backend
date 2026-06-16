<?php

namespace App\Filament\Resources\PartnerSuccesses;

use App\Filament\Resources\PartnerSuccesses\Pages\CreatePartnerSuccess;
use App\Filament\Resources\PartnerSuccesses\Pages\EditPartnerSuccess;
use App\Filament\Resources\PartnerSuccesses\Pages\ListPartnerSuccesses;
use App\Filament\Resources\PartnerSuccesses\Pages\ViewPartnerSuccess;
use App\Filament\Resources\PartnerSuccesses\Schemas\PartnerSuccessForm;
use App\Filament\Resources\PartnerSuccesses\Schemas\PartnerSuccessInfolist;
use App\Filament\Resources\PartnerSuccesses\Tables\PartnerSuccessesTable;
use App\Models\PartnerSuccess;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PartnerSuccessResource extends Resource
{
    protected static ?string $model = PartnerSuccess::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

     public static function getNavigationLabel(): string
    {
        return __('strings.partners');
    }

    public static function getModelLabel(): string
    {
        return __('strings.partners');
    }

    public static function getPluralModelLabel(): string
    {
        return __('strings.partners');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return PartnerSuccessForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PartnerSuccessInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PartnerSuccessesTable::configure($table);
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
            'index' => ListPartnerSuccesses::route('/'),
            'create' => CreatePartnerSuccess::route('/create'),
            'view' => ViewPartnerSuccess::route('/{record}'),
            'edit' => EditPartnerSuccess::route('/{record}/edit'),
        ];
    }
}
