<?php

namespace App\Filament\Resources\Occasions\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use App\Filament\Schemas\Components\SlugField;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class OccasionForm
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
                    ->translatableTabs()
                    ->modifyFieldsUsing(SlugField::sourceCustomizer('name')),
                SlugField::make('name'),
                FileUpload::make('image')
                    ->label(__('strings.image'))
                    ->image()
                    ->directory('occasions')
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
