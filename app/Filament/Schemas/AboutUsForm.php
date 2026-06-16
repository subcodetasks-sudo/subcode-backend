<?php

namespace App\Filament\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class AboutUsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('AboutUsTabs')
                    ->tabs([
                        Tab::make(__('admin.content'))
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make()
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label(__('strings.title'))
                                            ->maxLength(255)
                                            ->required()
                                            ->translatableTabs(),

                                        MarkdownEditor::make('description')
                                            ->label(__('strings.description'))
                                            ->required()
                                            ->columnSpanFull()
                                            ->translatableTabs(),
                                    ]),
                            ]),

                        Tab::make(__('admin.media'))
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        FileUpload::make('image_ar')
                                            ->label(__('strings.image_ar'))
                                            ->required()
                                            ->disk('public')
                                            ->helperText(__('strings.image_hint'))
                                            ->image(),
                                        FileUpload::make('image_en')
                                            ->label(__('strings.image_en'))
                                            ->required()
                                            ->disk('public')
                                            ->helperText(__('strings.image_hint'))
                                            ->image(),
                                        FileUpload::make('image_tr')
                                            ->label(__('strings.image_tr'))
                                            ->required()
                                            ->disk('public')
                                            ->helperText(__('strings.image_hint'))
                                            ->image(),

                                        SeoSection::imageAltField()
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        SeoSection::tab(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
