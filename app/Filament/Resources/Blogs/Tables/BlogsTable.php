<?php

namespace App\Filament\Resources\Blogs\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;

class BlogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                   ImageColumn::make('image')
                     ->disk('public')
                    ->label(__('admin.image'))
                    ->sortable(),
             
                  TextColumn::make('category.name')->label(__('admin.category')),
                  TextColumn::make('title')->label(__('admin.title')),
                  
      
                  ToggleColumn::make('is_active')
                    ->label(__('admin.is_active')),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('category_id')
                    ->relationship('category' , 'name')
                    ->label(__('admin.category')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
