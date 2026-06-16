<?php

namespace App\Filament\Resources\FQS\Pages;

use App\Filament\Resources\FQS\FQResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFQS extends ListRecords
{
    protected static string $resource = FQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
