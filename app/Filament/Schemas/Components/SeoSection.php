<?php

namespace App\Filament\Schemas\Components;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;

class SeoSection
{
    public static function translatableMetaFields(?string $tabsLabel = null): TranslatableTabs
    {
        return TranslatableTabs::make($tabsLabel ?? __('admin.seo'))
            ->schema([
                RichEditor::make('meta_title')
                    ->label(__('admin.meta_title'))
                    ->columnSpanFull(),
                RichEditor::make('meta_description')
                    ->label(__('admin.meta_description'))
                    ->columnSpanFull(),
            ])
            ->columnSpanFull();
    }

    public static function fields(): array
    {
        return [
            Group::make()
                ->relationship('meta')
                ->schema([
                    self::translatableMetaFields(),
                    ...SocialSection::fields(),
                ])
                ->columnSpanFull(),
        ];
    }

    public static function section(): Section
    {
        return Section::make(__('admin.seo'))
            ->icon('heroicon-o-magnifying-glass')
            ->schema(self::fields())
            ->columnSpanFull();
    }

    public static function tab(): Tab
    {
        return Tab::make(__('admin.seo'))
            ->icon('heroicon-o-magnifying-glass')
            ->schema(self::fields());
    }

    public static function imageAltField(string $field = 'image_alt'): TranslatableTabs
    {
        return TextInput::make($field)
            ->label(__('strings.image_alt'))
            ->maxLength(255)
            ->translatableTabs();
    }
}
