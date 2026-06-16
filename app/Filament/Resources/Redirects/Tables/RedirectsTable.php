<?php

namespace App\Filament\Resources\Redirects\Tables;

use App\Support\RedirectResourceType;
use App\Support\RedirectStatusCodes;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RedirectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source_path')
                    ->label(__('admin.redirect_source_path'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('target_path')
                    ->label(__('admin.redirect_target_path'))
                    ->searchable()
                    ->placeholder('—')
                    ->copyable(),
                TextColumn::make('status_code')
                    ->label(__('admin.redirect_status_code'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('resource_type')
                    ->label(__('admin.redirect_resource_type'))
                    ->formatStateUsing(fn (string $state): string => RedirectResourceType::options()[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('source_locale')
                    ->label(__('admin.redirect_locale'))
                    ->badge(),
                IconColumn::make('is_active')
                    ->label(__('admin.active'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label(__('strings.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('resource_type')
                    ->label(__('admin.redirect_resource_type'))
                    ->options(RedirectResourceType::options()),
                SelectFilter::make('source_locale')
                    ->label(__('admin.redirect_locale'))
                    ->options([
                        'ar' => __('strings.ar'),
                        'en' => __('strings.en'),
                        'tr' => __('strings.tr'),
                    ]),
                SelectFilter::make('status_code')
                    ->label(__('admin.redirect_status_code'))
                    ->options(RedirectStatusCodes::options()),
                TernaryFilter::make('is_active')
                    ->label(__('admin.active')),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
