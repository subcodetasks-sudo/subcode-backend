<?php

namespace App\Filament\Resources\FQS\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FQForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.faq_information'))
                    ->schema([
                        TextInput::make('question')
                            ->label(__('admin.question'))
                            ->required()
                            ->maxLength(500)->translatableTabs(),
                        Textarea::make('answer')
                            ->label(__('admin.answer'))
                            ->required()
                            ->maxLength(2000)
                            ->rows(6)->translatableTabs()
                            ->columnSpanFull(),
                  
                    ])->columns(2)->columnSpanFull(),

                SeoSection::section(),
            ]);
    }
}
