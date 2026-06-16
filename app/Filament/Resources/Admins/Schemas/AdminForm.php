<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class AdminForm
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
                            
                        Select::make('role')
                            ->label(__('admin.role'))
                            ->required()
                            ->options(Role::pluck('name', 'name')),
                       

                            
                            
                        TextInput::make('email')
                            ->label(__('admin.email'))
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label(__('admin.phone'))
                            ->tel()
                            ->maxLength(20),
                        FileUpload::make('image')
                            ->label(__('admin.avatar'))
                            ->image()
                            ->disk('public')
                            ->directory('admins/avatars'),
                    ])->columns(2),

                Section::make(__('admin.account_settings'))
                    ->schema([
                        TextInput::make('password')
                            ->label(__('admin.password'))
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                        Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
