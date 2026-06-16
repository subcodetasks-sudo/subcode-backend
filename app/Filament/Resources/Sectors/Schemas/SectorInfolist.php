<?php

namespace App\Filament\Resources\Sectors\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

class SectorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('strings.name')),
                        ImageEntry::make('image')
                            ->label(__('strings.image'))
                            ->disk('public'),
                        IconEntry::make('is_active')
                            ->label(__('strings.is_active'))
                            ->boolean(),
                    ]),
            ]);
    }
}
