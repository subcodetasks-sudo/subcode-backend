<?php

namespace App\Filament\Resources\FeaturePackages\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use App\Models\Package;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FeaturePackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('strings.name'))
                            ->maxLength(255)
                            ->required()
                            ->translatableTabs(),
                        Select::make('package_id')
                            ->label(__('strings.packages'))
                            ->multiple()
                            ->options(Package::all()->pluck('name', 'id'))
                            ->required(),
                    ]),

                SeoSection::section(),
            ]);
    }
}
