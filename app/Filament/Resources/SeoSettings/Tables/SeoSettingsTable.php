<?php

namespace App\Filament\Resources\SeoSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeoSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page_key')
                    ->label(__('strings.page_key'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('page_name')
                    ->label(__('strings.page_name'))
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label(__('strings.updated_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
