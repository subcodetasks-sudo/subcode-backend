<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('name')
                        ->label(__('strings.name'))
                        ->required()
                        ->translatableTabs(),

                    TextInput::make('code')
                        ->label(__('strings.code'))
                        ->required()
                        ->maxLength(10)
                        ->unique(ignoreRecord: true)
                        ->helperText(__('strings.country_code_hint')),

                    Toggle::make('is_active')
                        ->label(__('strings.is_active'))
                        ->default(true),
                ]),
        ]);
    }
}
