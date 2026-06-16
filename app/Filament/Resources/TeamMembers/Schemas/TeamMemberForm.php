<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('admin.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('specialty')
                            ->label(__('admin.specialty'))
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('image')
                            ->label(__('admin.image'))
                            ->disk('public')
                            ->image()
                            ->maxSize(2048)
                            ->helperText(__('strings.image_hint')),
                        SeoSection::imageAltField(),
                        Toggle::make('is_active')
                            ->label(__('admin.is_active'))
                            ->default(true)
                            ->required(),
                    ])->columns(2)->columnSpanFull(),

                SeoSection::section(),
            ]);
    }
}
