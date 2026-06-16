<?php

namespace App\Filament\Resources\Sectors\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class SectorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                TextInput::make('name')
                    ->label(__('strings.name'))
                    ->required()
                    ->translatableTabs(),
                FileUpload::make('image')
                    ->label(__('strings.image'))
                    ->image()
                    ->directory('sectors')
                    ->disk('public'),
                SeoSection::imageAltField(),
                Toggle::make('is_active')
                    ->label(__('strings.is_active'))
                    ->default(true)
                    ->required(),   
                ]),

                SeoSection::section(),
            ]);
    }
}
