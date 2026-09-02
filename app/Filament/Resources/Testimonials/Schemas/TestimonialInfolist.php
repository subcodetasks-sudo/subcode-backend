<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Models\Testimonial;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class TestimonialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.client_information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ImageEntry::make('client_image')
                                    ->label(__('admin.client_image'))
                                    ->disk('public')
                                    ->height(150)
                                    ->visible(fn (Testimonial $record): bool => $record->client_image && ! Testimonial::isVideoPath($record->client_image)),
                                TextEntry::make('client_image')
                                    ->label(__('admin.client_image'))
                                    ->formatStateUsing(fn (?string $state): ?string => $state ? url("storage/{$state}") : null)
                                    ->url(fn (?string $state): ?string => $state ? url("storage/{$state}") : null)
                                    ->openUrlInNewTab()
                                    ->visible(fn (Testimonial $record): bool => Testimonial::isVideoPath($record->client_image)),
                                Grid::make(1)
                                    ->schema([
                                        TextEntry::make('client_name')
                                            ->label(__('admin.client_name'))
                                            ->size('lg')
                                            ->weight('bold'),
                                    ]),
                            ]),
                    ]),

                Section::make(__('admin.description'))
                    ->schema([
                        TextEntry::make('description')
                            ->label(__('admin.description'))
                            ->columnSpanFull(),
                    ]),

                Section::make(__('admin.project_information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ImageEntry::make('project_image')
                                    ->label(__('admin.project_image'))
                                    ->disk('public')
                                    ->height(150)
                                    ->visible(fn (Testimonial $record): bool => $record->project_image && ! Testimonial::isVideoPath($record->project_image)),
                                TextEntry::make('project_image')
                                    ->label(__('admin.project_image'))
                                    ->formatStateUsing(fn (?string $state): ?string => $state ? url("storage/{$state}") : null)
                                    ->url(fn (?string $state): ?string => $state ? url("storage/{$state}") : null)
                                    ->openUrlInNewTab()
                                    ->visible(fn (Testimonial $record): bool => Testimonial::isVideoPath($record->project_image)),
                                TextEntry::make('project_name')
                                    ->label(__('admin.project_name'))
                                    ->size('lg')
                                    ->weight('bold'),
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
