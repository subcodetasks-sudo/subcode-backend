<?php

namespace App\Filament\Resources\Packages\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class PackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('strings.name'))
                    ->searchable(),
                TextColumn::make('price')
                    ->label(__('strings.price'))
                    ->money()
                    ->sortable(),

                    TextColumn::make('type')
                        ->label(__('strings.type'))
                        ->formatStateUsing(fn (string $state) => match ($state) {
                            'programming' => __('strings.programming'),
                            'marketing' => __('strings.marketing'),
                            default => $state,
                        }),

                    ToggleColumn::make('status')
                    ->label(__('strings.status')),
              
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
