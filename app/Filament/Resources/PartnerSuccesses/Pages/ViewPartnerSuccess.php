<?php

namespace App\Filament\Resources\PartnerSuccesses\Pages;

use App\Filament\Resources\PartnerSuccesses\PartnerSuccessResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPartnerSuccess extends ViewRecord
{
    protected static string $resource = PartnerSuccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
