<?php

namespace App\Filament\Resources\FQS\Pages;

use App\Filament\Resources\FQS\FQResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFQ extends ViewRecord
{
    protected static string $resource = FQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
