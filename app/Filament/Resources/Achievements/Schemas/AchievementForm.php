<?php

namespace App\Filament\Resources\Achievements\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AchievementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('strings.title'))
                            ->maxLength(255)
                            ->required()
                            ->translatableTabs()
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->label(__('strings.image'))
                            ->image()
                            ->required()
                            ->disk('public')
                            ->directory('achievements')
                            ->maxSize(2048)
                            ->helperText(__('strings.image_hint'))
                            ->columnSpanFull(),
                        SeoSection::imageAltField()
                            ->columnSpanFull(),
                    ]),

                SeoSection::section(),
            ]);
    }
}
