<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.testimonial_content'))
                    ->schema([
                        FileUpload::make('media')
                            ->label(__('admin.media'))
                            ->disk('public')
                            ->directory('testimonials')
                            ->required()
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                                'image/webp',
                                'video/mp4',
                                'video/webm',
                                'video/quicktime',
                            ])
                            ->helperText(__('strings.media_hint')),
                        Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                            ->default(true)
                            ->required(),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}
