<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.basic_information'))
                    ->schema([

                        TextEntry::make('name')
                            ->label(__('admin.category_name')),
                        TextEntry::make('slug')
                            ->label(__('strings.slug')),

                        ImageEntry::make('image')
                            ->disk('public')
                            ->label(__('admin.image')),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}
