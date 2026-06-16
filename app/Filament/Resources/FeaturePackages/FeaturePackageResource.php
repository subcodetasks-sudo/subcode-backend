<?php

namespace App\Filament\Resources\FeaturePackages;

use App\Filament\Resources\FeaturePackages\Pages\CreateFeaturePackage;
use App\Filament\Resources\FeaturePackages\Pages\EditFeaturePackage;
use App\Filament\Resources\FeaturePackages\Pages\ListFeaturePackages;
use App\Filament\Resources\FeaturePackages\Pages\ViewFeaturePackage;
use App\Filament\Resources\FeaturePackages\Schemas\FeaturePackageForm;
use App\Filament\Resources\FeaturePackages\Schemas\FeaturePackageInfolist;
use App\Filament\Resources\FeaturePackages\Tables\FeaturePackagesTable;
use App\Models\FeaturePackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FeaturePackageResource extends Resource
{
    protected static ?string $model = FeaturePackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Star;

    public static function getNavigationLabel(): string
    {
        return __('strings.feature_packages');
    }

    public static function getModelLabel(): string
    {
        return __('strings.feature_packages');
    }

    public static function getPluralModelLabel(): string
    {
        return __('strings.feature_packages');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return FeaturePackageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FeaturePackageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeaturePackagesTable::configure($table);
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
            'index' => ListFeaturePackages::route('/'),
            // 'create' => CreateFeaturePackage::route('/create'),
            // 'view' => ViewFeaturePackage::route('/{record}'),
            // 'edit' => EditFeaturePackage::route('/{record}/edit'),
        ];
    }
}
