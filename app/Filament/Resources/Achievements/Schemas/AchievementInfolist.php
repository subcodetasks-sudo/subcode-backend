<?php

namespace App\Filament\Resources\Achievements\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AchievementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('title')
                            ->label(__('strings.title')),
                        ImageEntry::make('image')
                            ->disk('public')
                            ->label(__('strings.image')),
                    ]),
            ]);
    }
}
