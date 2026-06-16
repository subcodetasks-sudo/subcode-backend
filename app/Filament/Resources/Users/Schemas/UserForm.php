<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.personal_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('admin.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('admin.email'))
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('mobile')
                            ->label(__('admin.mobile'))
                            ->tel()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        FileUpload::make('image')
                            ->label(__('admin.avatar'))
                            ->disk('public')
                            ->image()
                            ->directory('users/avatars'),
                    ])->columns(2),

                Section::make(__('admin.account_status'))
                    ->schema([
                        Toggle::make('email_verified_at')
                            ->label(__('admin.email_verified'))
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('email_verified_at', $state ? now() : null);
                            }),
                        DateTimePicker::make('email_verified_at')
                            ->label(__('admin.email_verified_at'))
                            ->disabled(),
                        DateTimePicker::make('mobile_verified_at')
                            ->label(__('admin.mobile_verified_at'))
                            ->disabled(),
                        TextInput::make('verification_code')
                            ->label(__('admin.verification_code'))
                            ->disabled(),
                    ])->columns(2),

                Section::make(__('admin.security'))
                    ->schema([
                        TextInput::make('password')
                            ->label(__('admin.password'))
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                    ]),
            ]);
    }
}
