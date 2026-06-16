<?php

namespace App\Filament\Resources\PartnerSuccesses\Pages;

use App\Filament\Resources\PartnerSuccesses\PartnerSuccessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPartnerSuccesses extends ListRecords
{
    protected static string $resource = PartnerSuccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
