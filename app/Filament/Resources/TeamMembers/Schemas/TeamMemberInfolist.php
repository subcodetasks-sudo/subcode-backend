<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamMemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        ImageEntry::make('image')
                            ->label(__('admin.image'))
                            ->disk('public')
                            ->circular()
                            ->size(150),
                        TextEntry::make('name')
                            ->label(__('admin.name')),
                        TextEntry::make('specialty')
                            ->label(__('admin.specialty')),
                        TextEntry::make('is_active')
                            ->label(__('admin.is_active'))
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn ($state) => $state ? __('admin.active') : __('admin.inactive')),
                       
                            ])->columns(2)->columnSpanFull(),
            ]);
    }
}

