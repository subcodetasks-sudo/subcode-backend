<?php

namespace App\Filament\Resources\Websites\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;

class WebsitesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('strings.name'))
                    ->limit(25)
                    ->searchable(),
                TextColumn::make('caption')
                    ->label(__('strings.caption'))
                    ->limit(25)
                    ->searchable(),
                ImageColumn::make('main_image')
                    ->disk('public')
                    ->label(__('strings.main_image')),
              
                ToggleColumn::make('status')
                    ->label(__('strings.status')),
                TextColumn::make('department.name')
                    ->label(__('strings.department'))
                    ->searchable(),
               
            ])
            ->filters([
                SelectFilter::make('department_id')
                    ->label(__('strings.department'))
                    ->relationship('department', 'name')
                    ->multiple()
                    ->searchable(),
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

