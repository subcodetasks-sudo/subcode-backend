<?php

namespace App\Filament\Resources\SuccessNumbers\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class SuccessNumberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('title')
                            ->label(__('admin.title')),
                        
                        TextEntry::make('number')
                            ->label(__('admin.number'))
                            ->numeric(),
                        
                         
                        
                        IconEntry::make('is_active')
                            ->label(__('admin.is_active'))
                            ->boolean()
                            ->trueIcon('heroicon-s-check-circle')
                            ->falseIcon('heroicon-s-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        
                        TextEntry::make('created_at')
                            ->label(__('admin.created_at'))
                            ->dateTime(),
                        
                        TextEntry::make('updated_at')
                            ->label(__('admin.updated_at'))
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}

