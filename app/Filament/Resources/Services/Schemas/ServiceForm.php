<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use App\Filament\Schemas\Components\SlugField;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class ServiceForm
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
                            ->maxLength(255)
                            ->label(__('strings.title'))
                            ->required()
                            ->translatableTabs()
                            ->modifyFieldsUsing(SlugField::sourceCustomizer('title')),
                        SlugField::make('title'),
                        Textarea::make('description')
                            ->label(__('strings.description'))
                            ->required()
                            ->columnSpanFull()
                            ->translatableTabs(),

                        FileUpload::make('image')
                            ->label(__('strings.image'))
                            ->disk('public')
                            ->image()
                            ->required()
                            ->helperText(__('strings.image_hint'))
                            ->columnSpanFull(),

                        SeoSection::imageAltField()
                            ->columnSpanFull(),

                        Repeater::make('features')
                            ->relationship('features')
                            ->label(__('strings.features'))
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('strings.title'))
                                    ->required()->maxLength(255)
                                    ->translatableTabs(),
                            ])->columnSpanFull()
                            ->grid(2)
                    ]),

                Section::make()
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('featureServices')
                            ->relationship('featureServices')
                            ->label(__('strings.features'))
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('strings.title'))
                                    ->required()->maxLength(255)
                                    ->translatableTabs(),
                                Textarea::make('description')
                                    ->label(__('strings.description'))
                                    ->required()
                                    ->translatableTabs(),

                                FileUpload::make('image')
                                    ->label(__('strings.image'))
                                    ->disk('public')
                                    ->image()
                                    ->required()
                                    ->helperText(__('strings.image_hint'))
                                    ->columnSpanFull(),

                                SeoSection::imageAltField()
                                    ->columnSpanFull(),
                            ])->columnSpanFull()
                            ->grid(2)
                    ]),

                Section::make(__('admin.faqs'))
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('faqs')
                            ->relationship('faqs')
                            ->label(__('admin.faqs'))
                            ->orderColumn('sort_order')
                            ->collapsible()
                            ->defaultItems(0)
                            ->schema([
                                TextInput::make('question')
                                    ->label(__('admin.question'))
                                    ->required()
                                    ->maxLength(500)
                                    ->translatableTabs(),
                                Textarea::make('answer')
                                    ->label(__('admin.answer'))
                                    ->required()
                                    ->maxLength(2000)
                                    ->rows(4)
                                    ->translatableTabs()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                    ]),

                SeoSection::section(),
            ]);
    }
}
