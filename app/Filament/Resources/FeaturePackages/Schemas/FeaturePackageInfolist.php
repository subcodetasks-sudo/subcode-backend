<?php

namespace App\Filament\Resources\FeaturePackages\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class FeaturePackageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('strings.name')),

                            // TextEntry::make('package.name')
                            // ->label(__('strings.packages'))
                            // ->bulleted(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
               
            ]);
    }
}
