<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PackageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('strings.name')),
                        TextEntry::make('price')
                            ->label(__('strings.price'))
                            ->money(),

                        TextEntry::make('type')
                            ->formatStateUsing(fn (string $state) => match ($state) {
                                'programming' => __('strings.programming'),
                                'marketing' => __('strings.marketing'),
                                default => $state,
                            })
                            ->label(__('strings.type')),

                        IconEntry::make('status')
                            ->label(__('strings.status'))
                            ->boolean(),

                        TextEntry::make('description')
                            ->label(__('strings.description'))
                            ->columnSpanFull(),

                        TextEntry::make('features')
                            ->label(__('strings.features'))
                            ->columnSpanFull(),

                    ]),
            ]);
    }
}
