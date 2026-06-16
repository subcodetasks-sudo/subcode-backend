<?php

namespace App\Filament\Resources\Departments\Schemas;

use App\Filament\Schemas\Components\SeoSection;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('strings.name'))
                    ->maxLength(255)
                    ->required()
                    ->translatableTabs(),

                SeoSection::section(),
            ]);
    }
}
