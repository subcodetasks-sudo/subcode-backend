<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use App\Filament\Schemas\Components\SlugField;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs\Tab;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('ProjectTabs')
                ->tabs([
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
                                        ->translatableTabs()
                                        ->modifyFieldsUsing(SlugField::sourceCustomizer('name')),

                                    SlugField::make('name'),
                                    Textarea::make('description')
                                        ->label('الوصف')
                                        ->rows(5),

                                    Select::make('department_id')
                                        ->label(__('strings.department'))
                                        ->relationship('department', 'name')
                                        ->searchable()
                                        ->required()
                                        ->preload(),

                                    FileUpload::make('main_image')
                                        ->label(__('strings.main_image'))
                                        ->disk('public')
                                        ->image()
                                        ->imageEditor()
                                        ->imageCropAspectRatio('16:9'),

                                    SeoSection::imageAltField('main_image_alt'),

                                    Toggle::make('status')
                                        ->label(__('strings.status'))
                                        ->default(true),

                                    TextInput::make('link_project')
                                        ->label(__('strings.link_project'))
                                        ->url()
                                        ->maxLength(255)
                                        ->placeholder('https://example.com')
                                        ->suffixIcon('heroicon-o-link')
                                        ->required(),

                                    Toggle::make('is_special')
                                        ->label(__('strings.is_special'))
                                        ->default(false),
                                ]),
                        ]),

                    SeoSection::tab(),
                ])
                ->columnSpanFull(),
        ]);
    }
}
