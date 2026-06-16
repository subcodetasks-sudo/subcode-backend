<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class BlogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Section::make(__('admin.blogs'))
                    ->schema([
                        ImageEntry::make('image')
                            ->disk('public')
                            ->label(__('admin.image')),

                        TextEntry::make('title')
                            ->label(__('admin.title')),

                        TextEntry::make('description')
                            ->label(__('admin.description'))
                            ->html()
                            ->getStateUsing(fn ($record) => strip_tags($record->description)),

                    

                        TextEntry::make('category.name')
                            ->label(__('admin.category')),
                         

                        TextEntry::make('status')
                            ->label(__('admin.status'))
                            ->badge(),

                        TextEntry::make('time_publish')
                            ->label(__('admin.time_publish'))
                            ->dateTime()
                            ->hidden(fn ($record) => $record->status !== 'schedule'),

                        TextEntry::make('created_at')
                            ->label(__('admin.created_at'))
                            ->dateTime(),

                    ])
                    ->columns(2),

                  Section::make(__('admin.seo'))
                    ->schema([
                        TextEntry::make('meta.meta_title')
                            ->label(__('admin.meta_title')),

                        TextEntry::make('meta.meta_description')
                            ->label(__('admin.meta_description')),

                        TextEntry::make('image_alt')
                            ->label(__('strings.image_alt')),
                    ])
                    ->columns(2),
            ]);
    }
}
