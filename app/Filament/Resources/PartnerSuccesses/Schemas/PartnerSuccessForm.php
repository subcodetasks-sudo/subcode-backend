<?php

namespace App\Filament\Resources\PartnerSuccesses\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class PartnerSuccessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                TextInput::make('title')
                    ->label(__('strings.title'))
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->required()
                    ->translatableTabs(),
                FileUpload::make('image')
                    ->label(__('strings.image'))
                    ->image()
                    ->required()
                    ->disk('public')
                    ->maxSize(2048)
                    ->columnSpanFull()->helperText(__('strings.image_hint')),
                SeoSection::imageAltField()
                    ->columnSpanFull(),
                    ]),

                SeoSection::section(),
            ]);
    }
}
