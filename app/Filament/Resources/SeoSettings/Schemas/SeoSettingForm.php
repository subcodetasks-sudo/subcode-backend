<?php

namespace App\Filament\Resources\SeoSettings\Schemas;

use Filament\Forms\Components\TextInput;
use App\Filament\Schemas\Components\SeoSection;
use App\Filament\Schemas\Components\SocialSection;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SeoSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('page_key')
                            ->label(__('strings.page_key'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabledOn('edit'),
                        TextInput::make('page_name')
                            ->label(__('strings.page_name'))
                            ->required()
                            ->translatableTabs()
                            ->columnSpanFull(),
                        SeoSection::translatableMetaFields(),
                        ...SocialSection::fields(),
                    ]),
            ]);
    }
}
