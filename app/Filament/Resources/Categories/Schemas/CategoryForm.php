<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.basic_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('admin.category_name'))
                            ->required()
                            ->maxLength(255)->translatableTabs(),
                    ]),

                Section::make(__('admin.media'))
                    ->schema([
                        FileUpload::make('image')
                            ->label(__('admin.image'))
                            ->disk('public')
                            ->image(),
                        SeoSection::imageAltField(),
                    ]),

                SeoSection::section(),
            ]);
    }
}
