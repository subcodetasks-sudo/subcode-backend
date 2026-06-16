<?php

namespace App\Filament\Resources\FQS\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FQInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.faq_information'))
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('question')
                            ->label(__('admin.question'))
                            ->size('lg')
                            ->weight('bold')
                            ->columnSpanFull(),
                        TextEntry::make('answer')
                            ->label(__('admin.answer'))
                            ->html()
                            ->columnSpanFull(),
                    ]),

            ]);
    }
}
