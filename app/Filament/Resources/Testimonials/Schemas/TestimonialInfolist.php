<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Models\Testimonial;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.testimonial_content'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ImageEntry::make('media')
                                    ->label(__('admin.media'))
                                    ->disk('public')
                                    ->height(200)
                                    ->visible(fn (Testimonial $record): bool => $record->media && ! Testimonial::isVideoPath($record->media)),
                                TextEntry::make('media')
                                    ->label(__('admin.media'))
                                    ->formatStateUsing(fn (?string $state): ?string => $state ? url("storage/{$state}") : null)
                                    ->url(fn (?string $state): ?string => $state ? url("storage/{$state}") : null)
                                    ->openUrlInNewTab()
                                    ->visible(fn (Testimonial $record): bool => Testimonial::isVideoPath($record->media)),
                            ]),
                    ]),

                Section::make(__('admin.status'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                IconEntry::make('is_active')
                                    ->label(__('admin.is_active'))
                                    ->boolean(),
                                TextEntry::make('created_at')
                                    ->label(__('admin.created_at'))
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->label(__('admin.updated_at'))
                                    ->dateTime(),
                            ]),
                    ]),
            ]);
    }
}
