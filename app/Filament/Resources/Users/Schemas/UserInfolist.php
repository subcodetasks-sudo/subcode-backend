<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.personal_information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ImageEntry::make('image')
                                    ->label(__('admin.avatar'))
                                    ->disk('public')
                                    ->height(100),
                                Grid::make(1)
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label(__('admin.name'))
                                            ->size('lg')
                                            ->weight('bold'),
                                        TextEntry::make('email')
                                            ->label(__('admin.email')),
                                        TextEntry::make('mobile')
                                            ->label(__('admin.mobile'))
                                            ->copyable(),
                                    ]),
                            ]),
                    ]),

                Section::make(__('admin.account_status'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                IconEntry::make('email_verified_at')
                                    ->label(__('admin.email_verified'))
                                    ->boolean(),
                                IconEntry::make('mobile_verified_at')
                                    ->label(__('admin.mobile_verified'))
                                    ->boolean(),
                                TextEntry::make('verification_code')
                                    ->label(__('admin.verification_code'))
                                    ->placeholder(__('admin.no_code')),
                            ]),
                    ]),

                Section::make(__('admin.timestamps'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('email_verified_at')
                                    ->label(__('admin.email_verified_at'))
                                    ->dateTime(),
                                TextEntry::make('mobile_verified_at')
                                    ->label(__('admin.mobile_verified_at'))
                                    ->dateTime(),
                                TextEntry::make('created_at')
                                    ->label(__('admin.created_at'))
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->label(__('admin.updated_at'))
                                    ->dateTime(),
                            ]),
                    ]),
            ]);
    }
}
