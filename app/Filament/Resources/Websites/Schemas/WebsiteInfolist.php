<?php

namespace App\Filament\Resources\Websites\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class WebsiteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('WebsiteDetails')
                ->tabs([

                    // 🧩 Basic Info
                    Tab::make(__('strings.basic_info'))
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Section::make()
                                ->schema([
                                    ImageEntry::make('main_image')
                                        ->label(__('strings.main_image'))
                                        ->disk('public')
                                        ->columnSpanFull(),

                                    TextEntry::make('name')
                                        ->label(__('strings.name')),

                                    TextEntry::make('caption')
                                        ->label(__('strings.caption')),

                                    TextEntry::make('department.name')
                                        ->label(__('strings.department')),

                                    IconEntry::make('status')
                                        ->label(__('strings.status'))
                                        ->boolean()
                                        ->trueIcon('heroicon-s-check-circle')
                                        ->falseIcon('heroicon-s-x-circle')
                                        ->trueColor('success')
                                        ->falseColor('danger'),

                                    IconEntry::make('is_special')
                                        ->label(__('strings.is_special'))
                                        ->boolean()
                                        ->trueIcon('heroicon-s-check-circle')
                                        ->falseIcon('heroicon-s-x-circle')
                                        ->trueColor('success')
                                        ->falseColor('danger'),
                                ])->columns(2),
                        ]),

                    // 📄 Description
                    Tab::make(__('strings.details'))
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextEntry::make('description')
                                        ->label(__('strings.description'))
                                        ->columnSpanFull(),

                                    TextEntry::make('long_description')
                                        ->label(__('strings.long_description'))
                                        ->columnSpanFull(),

                                    TextEntry::make('link_website')
                                        ->label(__('admin.link_website'))
                                        ->url(fn ($record) => $record->link_website)
                                        ->openUrlInNewTab()
                                        ->icon('heroicon-o-link')
                                        ->color('primary'),
                                ]),
                        ]),

                    Tab::make(__('strings.media'))
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Section::make(__('strings.images'))
                                ->schema([
                                    ImageEntry::make('images')
                                        ->label(__('strings.images'))
                                        ->stacked()
                                        ->square()
                                        ->disk('public')
                                        ->columnSpanFull(),
                                ]),
                            Section::make(__('strings.technologies'))
                                ->schema([
                                    ImageEntry::make('technologies')
                                        ->label(__('strings.technologies'))
                                        ->stacked()
                                        ->disk('public')
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    // ⭐ Advantages
                    Tab::make(__('strings.advantages'))
                        ->icon('heroicon-o-star')
                        ->schema([
                            Section::make()
                                ->schema([
                                    RepeatableEntry::make('advantageWebsites')
                                        ->label(__('strings.advantages'))
                                        ->schema([
                                            TextEntry::make('title')
                                                ->label(__('strings.title')),
                                            TextEntry::make('description')
                                                ->label(__('strings.description'))
                                                ->markdown(),
                                        ])
                                        ->grid(2)
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    // 💬 Reviews
                    Tab::make(__('strings.reviews'))
                        ->icon('heroicon-o-chat-bubble-bottom-center-text')
                        ->schema([
                            Section::make()
                                ->schema([
                                    RepeatableEntry::make('reviewWebsites')
                                        ->label(__('strings.reviews'))
                                        ->schema([
                                            ImageEntry::make('image')
                                                ->label(__('strings.image'))
                                                ->disk('public')
                                                ->stacked(),

                                            TextEntry::make('name')
                                                ->label(__('strings.name')),

                                            TextEntry::make('project_name')
                                                ->label(__('strings.project_name')),

                                            TextEntry::make('description')
                                                ->label(__('strings.description')),

                                            ImageEntry::make('project_image')
                                                ->disk('public')
                                                ->label(__('strings.project_image')),
                                        ])->columns(2)
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    // 💳 Subscriptions
                    Tab::make(__('strings.subscriptions'))
                        ->icon('heroicon-o-credit-card')
                        ->schema([
                            Section::make()
                                ->schema([
                                    RepeatableEntry::make('subscriptions')
                                        ->label(__('strings.subscriptions'))
                                        ->schema([
                                            TextEntry::make('name')
                                                ->label(__('strings.name')),

                                            TextEntry::make('price')
                                                ->label(__('strings.price'))
                                                ->money(),

                                            TextEntry::make('type')
                                                ->label(__('strings.type'))
                                                ->formatStateUsing(fn (string $state) => match ($state) {
                                                    'monthly' => __('strings.monthly'),
                                                    'yearly' => __('strings.yearly'),
                                                    default => $state,
                                                }),

                                            IconEntry::make('status')
                                                ->label(__('strings.status'))
                                                ->boolean(),

                                            TextEntry::make('description')
                                                ->label(__('strings.description'))
                                                ->columnSpanFull(),

                                            TextEntry::make('features')
                                                ->label(__('strings.features'))
                                                ->columnSpanFull(),
                                        ])->columns(2)
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ])
                ->persistTabInQueryString()
                ->columnSpanFull(),
        ]);
    }
}

