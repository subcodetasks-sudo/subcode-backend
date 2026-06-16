<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.client_information'))
                    ->schema([
                        TextInput::make('client_name')
                            ->label(__('admin.client_name'))
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('client_image')
                            ->label(__('admin.client_image'))
                            ->disk('public')
                            ->image()
                            ->maxSize(2048)
                            ->helperText(__('strings.image_hint')),
                        SeoSection::imageAltField('client_image_alt'),
                    ])->columns(2)->columnSpanFull(),

                Section::make(__('admin.description'))
                    ->schema([
                        Textarea::make('description')
                            ->label(__('admin.description'))
                            ->required()
                            ->rows(5)
                            ->columnSpanFull()
                            ->translatableTabs(),
                    ])->columnSpanFull(),

                Section::make(__('admin.project_information'))
                    ->schema([
                        TextInput::make('project_name')
                            ->label(__('admin.project_name'))
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('project_image')
                            ->label(__('admin.project_image'))
                            ->disk('public')
                            ->image()
                            ->maxSize(2048)
                            ->helperText(__('strings.image_hint')),
                        SeoSection::imageAltField('project_image_alt'),
                        Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                            ->default(true)
                            ->required(),
                    ])->columns(2)->columnSpanFull(),

                SeoSection::section(),
            ]);
    }
}
