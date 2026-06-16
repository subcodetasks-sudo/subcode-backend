<?php

namespace App\Filament\Resources\Redirects\Schemas;

use App\Support\RedirectResourceType;
use App\Support\RedirectStatusCodes;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

class RedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('resource_type')
                            ->label(__('admin.redirect_resource_type'))
                            ->options(RedirectResourceType::options())
                            ->required()
                            ->native(false)
                            ->live(),

                        Select::make('source_locale')
                            ->label(__('admin.redirect_locale'))
                            ->options([
                                'ar' => __('strings.ar'),
                                'en' => __('strings.en'),
                                'tr' => __('strings.tr'),
                            ])
                            ->required()
                            ->native(false)
                            ->default('ar'),

                        TextInput::make('source_path')
                            ->label(__('admin.redirect_source_path'))
                            ->required()
                            ->maxLength(2048)
                            ->placeholder('/ar/blogs/old-slug')
                            ->helperText(__('admin.redirect_source_path_help'))
                            ->columnSpanFull()
                            ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule, $get) {
                                return $rule->where('source_locale', $get('source_locale'));
                            }),

                        Select::make('status_code')
                            ->label(__('admin.redirect_status_code'))
                            ->options(RedirectStatusCodes::options())
                            ->required()
                            ->native(false)
                            ->default(301)
                            ->live(),

                        TextInput::make('target_path')
                            ->label(__('admin.redirect_target_path'))
                            ->maxLength(2048)
                            ->placeholder('/ar/blogs/new-slug')
                            ->helperText(__('admin.redirect_target_path_help'))
                            ->columnSpanFull()
                            ->required(fn ($get) => RedirectStatusCodes::requiresTarget((int) $get('status_code'))),

                        Toggle::make('is_active')
                            ->label(__('admin.active'))
                            ->default(true)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
