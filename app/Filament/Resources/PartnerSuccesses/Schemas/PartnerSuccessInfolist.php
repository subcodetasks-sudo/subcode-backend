<?php

namespace App\Filament\Resources\PartnerSuccesses\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class PartnerSuccessInfolist
{
     public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                TextEntry::make('title')->label(__('strings.title')),
                ImageEntry::make('image')
                    ->disk('public')
                    ->label(__('strings.image')),
                    ])
            ]);
    }
}
