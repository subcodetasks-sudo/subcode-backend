<?php

namespace App\Filament\Resources\Packages\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use App\Filament\Schemas\Components\SlugField;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\MarkdownEditor;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('strings.name'))
                            ->maxLength(255)
                            ->required()->translatableTabs()
                            ->modifyFieldsUsing(SlugField::sourceCustomizer('name')),
                        SlugField::make('name'),
                        TextInput::make('price')
                            ->label(__('strings.price'))
                            ->minValue(0)
                            ->required()
                            ->inputMode('decimal')
                            ->numeric(),

                        Group::make([
                            MarkdownEditor::make('description')
                                ->label(__('strings.description'))
                                ->translatableTabs(),
                        ])->columnSpanFull(),

                         Select::make('type')
                            ->label(__('strings.type'))
                            ->options([
                                'programming' => __('strings.programming'),
                                'marketing' => __('strings.marketing'),
                            ])
                            ->required(),

                        TagsInput::make('features')
                            ->label(__('strings.features'))
                            ->required()->columnSpanFull()
                            ->translatableTabs(),
                        Toggle::make('status')
                            ->label(__('strings.status'))
                            ->default(true),

                    ]),

                SeoSection::section(),
            ]);
    }
}
