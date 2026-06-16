<?php

namespace App\Filament\Resources\SeoSettings;

use App\Filament\Resources\SeoSettings\Pages\EditSeoSetting;
use App\Filament\Resources\SeoSettings\Pages\ListSeoSettings;
use App\Filament\Resources\SeoSettings\Schemas\SeoSettingForm;
use App\Filament\Resources\SeoSettings\Tables\SeoSettingsTable;
use App\Models\SeoSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SeoSettingResource extends Resource
{
    protected static ?string $model = SeoSetting::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?int $navigationSort = 99;

    public static function getNavigationGroup(): string
    {
        return __('admin.all_settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('strings.seo_settings');
    }

    public static function getModelLabel(): string
    {
        return __('strings.seo_setting');
    }

    public static function getPluralModelLabel(): string
    {
        return __('strings.seo_settings');
    }

    public static function form(Schema $schema): Schema
    {
        return SeoSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeoSettingsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeoSettings::route('/'),
            'edit' => EditSeoSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
