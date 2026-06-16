<?php

namespace App\Filament\Resources\SuccessNumbers\Pages;

use App\Filament\Resources\SuccessNumbers\SuccessNumberResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSuccessNumber extends ViewRecord
{
    protected static string $resource = SuccessNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

