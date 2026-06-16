<?php

namespace App\Filament\Schemas\Components;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class SocialSection
{
    public static function openGraphTypeOptions(): array
    {
        return [
            'website' => __('admin.og_type_website'),
            'article' => __('admin.og_type_article'),
            'product' => __('admin.og_type_product'),
        ];
    }

    public static function twitterCardOptions(): array
    {
        return [
            'summary' => __('admin.twitter_card_summary'),
            'summary_large_image' => __('admin.twitter_card_summary_large_image'),
        ];
    }

    public static function openGraphFields(): array
    {
        return [
            TranslatableTabs::make(__('admin.open_graph'))
                ->schema([
                    RichEditor::make('og_title')
                        ->label(__('admin.og_title'))
                        ->columnSpanFull(),
                    RichEditor::make('og_description')
                        ->label(__('admin.og_description'))
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
            FileUpload::make('og_image')
                ->label(__('admin.og_image'))
                ->image()
                ->disk('public')
                ->directory('seo/social')
                ->columnSpanFull(),
            Select::make('og_type')
                ->label(__('admin.og_type'))
                ->options(self::openGraphTypeOptions())
                ->native(false),
        ];
    }

    public static function twitterFields(): array
    {
        return [
            Select::make('twitter_card')
                ->label(__('admin.twitter_card'))
                ->options(self::twitterCardOptions())
                ->native(false),
            TranslatableTabs::make(__('admin.twitter'))
                ->schema([
                    RichEditor::make('twitter_title')
                        ->label(__('admin.twitter_title'))
                        ->columnSpanFull(),
                    RichEditor::make('twitter_description')
                        ->label(__('admin.twitter_description'))
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
            FileUpload::make('twitter_image')
                ->label(__('admin.twitter_image'))
                ->image()
                ->disk('public')
                ->directory('seo/social')
                ->columnSpanFull(),
        ];
    }

    public static function fields(): array
    {
        return [
            Section::make(__('admin.open_graph'))
                ->icon('heroicon-o-share')
                ->schema(self::openGraphFields())
                ->columns(1)
                ->columnSpanFull(),
            Section::make(__('admin.twitter'))
                ->icon('heroicon-o-chat-bubble-left-right')
                ->schema(self::twitterFields())
                ->columns(1)
                ->columnSpanFull(),
        ];
    }

    public static function globalDefaultsFields(): array
    {
        return [
            FileUpload::make('og_default_image')
                ->label(__('admin.og_default_image'))
                ->image()
                ->disk('public')
                ->directory('settings/social')
                ->columnSpanFull(),
            \Filament\Forms\Components\TextInput::make('twitter_site')
                ->label(__('admin.twitter_site'))
                ->maxLength(255)
                ->placeholder('@subcode'),
            Select::make('twitter_card_default')
                ->label(__('admin.twitter_card_default'))
                ->options(self::twitterCardOptions())
                ->native(false),
            \Filament\Forms\Components\TextInput::make('facebook_app_id')
                ->label(__('admin.facebook_app_id'))
                ->maxLength(255),
        ];
    }
}
