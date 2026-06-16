<?php

namespace App\Filament\Resources\SuccessNumbers\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class SuccessNumberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('admin.title'))
                            ->required()
                            ->maxLength(255)
                            ->translatableTabs(),
                        
                        TextInput::make('number')
                            ->label(__('admin.number'))
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step(1),
                        
                            FileUpload::make('icon')
                            ->label(__('strings.icon'))
                            ->disk('public')
                            ->image()
                            ->required()
                            ->maxSize(2048)
                            ->columnSpanFull()->helperText(__('strings.image_hint')),
                        
                        Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                            ->default(true)
                            ->required(),
                    ])->columns(2)->columnSpanFull(),

                SeoSection::section(),
            ]);
    }
}

