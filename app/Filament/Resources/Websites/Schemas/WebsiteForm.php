<?php

namespace App\Filament\Resources\Websites\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\MarkdownEditor;

class WebsiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('WebsiteTabs')
                ->tabs([

                    // 🧩 Basic Info
                    Tab::make(__('strings.basic_info'))
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Section::make()
                                ->description(__('strings.basic_info_description'))
                                ->columns(2)
                                ->schema([
                                    TextInput::make('name')
                                        ->label(__('strings.name'))
                                        ->maxLength(255)
                                        ->required()
                                        ->translatableTabs(),

                                    TextInput::make('caption')
                                        ->label(__('strings.caption'))
                                        ->maxLength(255)
                                        ->required()
                                        ->translatableTabs(),

                                    Select::make('department_id')
                                        ->label(__('strings.department'))
                                        ->relationship('department', 'name')
                                        ->searchable()
                                        ->required()
                                        ->preload(),

                                    TagsInput::make('tags')
                                        ->label(__('strings.tags'))
                                        ->required()
                                        ->translatableTabs(),

                                    FileUpload::make('main_image')
                                        ->label(__('strings.main_image'))
                                        ->disk('public')
                                        ->image()
                                        ->imageEditor()
                                        ->imageCropAspectRatio('16:9')
                                        ->required(),

                                    SeoSection::imageAltField('main_image_alt'),

                                    FileUpload::make('images')
                                        ->label(__('strings.images'))
                                        ->disk('public')
                                        ->multiple()
                                        ->panelLayout('grid')
                                        ->image()
                                        ->required()
                                        ->maxSize(2048) // 2MB
                                        ->helperText(__('strings.image_hint'))
                                        ->columnSpanFull(),

                                    Toggle::make('status')
                                        ->label(__('strings.status'))
                                        ->default(true),

                                    // Toggle::make('is_special')
                                    //     ->label(__('strings.is_special'))
                                    //     ->default(false),
                                ]),
                        ]),

                    Tab::make(__('strings.details'))
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Section::make()
                                ->description(__('strings.details_description'))
                                ->schema([
                                    MarkdownEditor::make('description')
                                        ->label(__('strings.description'))
                                        ->required()
                                        ->translatableTabs(),

                                    MarkdownEditor::make('long_description')
                                        ->label(__('strings.long_description'))
                                        ->required()
                                        ->translatableTabs(),

                                    TextInput::make('link_website')
                                        ->label(__('admin.link_website'))
                                        ->url()
                                        ->maxLength(255)
                                        ->placeholder('https://example.com')
                                        ->suffixIcon('heroicon-o-link')
                                        ->required(),
                                ]),
                        ]),

                    Tab::make(__('strings.media'))
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Section::make()
                                ->description(__('strings.media_description'))
                                ->schema([
                                    FileUpload::make('technologies')
                                        ->label(__('strings.technologies'))
                                        ->disk('public')
                                        ->multiple()
                                        ->panelLayout('grid')
                                        ->imagePreviewHeight('100')
                                        ->enableReordering()
                                        ->enableDownload()
                                        ->required()
                                        ->maxSize(2048) // 2MB
                                        ->helperText(__('strings.image_hint'))
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    Tab::make(__('strings.advantages'))
                        ->icon('heroicon-o-star')
                        ->schema([
                            Section::make()
                                ->description(__('strings.advantages_description'))
                                ->schema([
                                    Repeater::make('advantageWebsites')
                                        ->relationship()
                                        ->label(__('strings.advantages'))
                                        ->columns(1)
                                        ->schema([
                                            TextInput::make('title')
                                                ->label(__('strings.title'))
                                                ->required()
                                                ->maxLength(255)
                                                ->translatableTabs(),

                                            MarkdownEditor::make('description')
                                                ->label(__('strings.description'))
                                                ->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])
                                                ->required()
                                                ->columnSpanFull()
                                                ->translatableTabs(),
                                        ])
                                        ->defaultItems(1)
                                        ->minItems(1)
                                        ->maxItems(5)
                                        ->createItemButtonLabel(__('strings.add_advantage')),
                                ]),
                        ]),

                    Tab::make(__('strings.reviews'))
                        ->icon('heroicon-o-chat-bubble-bottom-center-text')
                        ->schema([
                            Section::make()
                                ->description(__('strings.reviews_description'))
                                ->schema([
                                    Repeater::make('reviewWebsites')
                                        ->label(__('strings.reviews'))
                                        ->relationship()
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('name')
                                                ->label(__('strings.name'))
                                                ->required()
                                                ->maxLength(255)
                                                ->translatableTabs(),

                                            TextInput::make('project_name')
                                                ->label(__('strings.project_name'))
                                                ->required()
                                                ->maxLength(255)
                                                ->translatableTabs(),

                                            Group::make()
                                                ->schema([
                                                    MarkdownEditor::make('description')
                                                        ->label(__('strings.description'))
                                                        ->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])
                                                        ->required()
                                                        ->columnSpanFull()
                                                        ->translatableTabs(),
                                                ])->columnSpanFull(),

                                            FileUpload::make('image')
                                                ->label(__('strings.user_image'))
                                                ->disk('public')
                                                ->image()
                                                ->maxSize(2048) // 2MB
                                                ->helperText(__('strings.image_hint'))
                                                ->required(),

                                            FileUpload::make('project_image')
                                                ->label(__('strings.project_image'))
                                                ->disk('public')
                                                ->image()
                                                ->maxSize(2048) // 2MB
                                                ->helperText(__('strings.image_hint'))
                                                ->required(),
                                        ]),
                                ]),
                        ]),

                    Tab::make(__('strings.subscriptions'))
                        ->icon('heroicon-o-credit-card')
                        ->schema([
                            Section::make()
                                ->description(__('strings.subscriptions_description'))
                                ->schema([
                                    Repeater::make('subscriptions')
                                        ->label(__('strings.subscriptions'))
                                        ->relationship()
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('name')
                                                ->label(__('strings.name'))
                                                ->required()
                                                ->maxLength(255)
                                                ->translatableTabs(),

                                            TextInput::make('price')
                                                ->label(__('strings.price'))
                                                ->numeric()
                                                ->minValue(0)
                                                ->required()
                                                ->inputMode('decimal')
                                                ->prefix('$')
                                                ->step('0.01'),

                                            Select::make('type')
                                                ->label(__('strings.type'))
                                                ->options([
                                                    'monthly' => __('strings.monthly'),
                                                    'yearly' => __('strings.yearly'),
                                                ])
                                                ->required(),

                                            Toggle::make('status')
                                                ->label(__('strings.status'))
                                                ->default(true),

                                            Group::make()
                                                ->schema([
                                                    MarkdownEditor::make('description')
                                                        ->label(__('strings.description'))
                                                        ->translatableTabs(),
                                                ])->columnSpanFull(),

                                            TagsInput::make('features')
                                                ->label(__('strings.features'))
                                                ->columnSpanFull()
                                                ->translatableTabs(),
                                        ])
                                        ->defaultItems(0)
                                        ->createItemButtonLabel(__('strings.add_subscription'))
                                        ->collapsible()
                                        ->collapsed(),
                                ]),
                        ]),

                    SeoSection::tab(),
                ])
                ->columnSpanFull(),
        ]);
    }
}

