<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                TextEntry::make('title')
                    ->label(__('strings.title')),
                TextEntry::make('description')
                    ->label(__('strings.description'))
                    ->columnSpanFull(),

                    ImageEntry::make('image')
                        ->disk('public')
                        ->label(__('strings.image')),


                    RepeatableEntry::make('features')
                        ->label(__('strings.features'))
                        ->schema([
                            TextEntry::make('title')
                                ->label(__('strings.title')),
                        ])->columnSpanFull()
                        ->grid(2),

                    RepeatableEntry::make('featureServices')
                        ->label(__('strings.features'))
                        ->schema([
                            TextEntry::make('title')
                                ->label(__('strings.title')),
                            TextEntry::make('description')
                                ->label(__('strings.description')),

                                ImageEntry::make('image')
                                    ->label(__('strings.image'))
                                    ->disk('public')
                                    
                                    ->helperText(__('strings.image_hint'))
                                    ->columnSpanFull(),
                        ])->columnSpanFull()
                        ->grid(2),

                    ]),
            ]);
    }
}
