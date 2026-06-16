<?php

namespace App\Filament\Resources\SuccessNumbers\Pages;

use App\Filament\Resources\SuccessNumbers\SuccessNumberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSuccessNumbers extends ListRecords
{
    protected static string $resource = SuccessNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

