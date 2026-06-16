<?php

namespace App\Filament\Resources\SuccessNumbers;

use App\Filament\Resources\SuccessNumbers\Pages\CreateSuccessNumber;
use App\Filament\Resources\SuccessNumbers\Pages\EditSuccessNumber;
use App\Filament\Resources\SuccessNumbers\Pages\ListSuccessNumbers;
use App\Filament\Resources\SuccessNumbers\Pages\ViewSuccessNumber;
use App\Filament\Resources\SuccessNumbers\Schemas\SuccessNumberForm;
use App\Filament\Resources\SuccessNumbers\Schemas\SuccessNumberInfolist;
use App\Filament\Resources\SuccessNumbers\Tables\SuccessNumbersTable;
use App\Models\SuccessNumber;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SuccessNumberResource extends Resource
{
    protected static ?string $model = SuccessNumber::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    public static function getNavigationLabel(): string
    {
        return __('admin.success_numbers');
    }

    public static function getModelLabel(): string
    {
        return __('admin.success_number');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('admin.success_numbers');
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return SuccessNumberForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SuccessNumberInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuccessNumbersTable::configure($table);
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
            'index' => ListSuccessNumbers::route('/'),
            'create' => CreateSuccessNumber::route('/create'),
            'view' => ViewSuccessNumber::route('/{record}'),
            'edit' => EditSuccessNumber::route('/{record}/edit'),
        ];
    }
}

