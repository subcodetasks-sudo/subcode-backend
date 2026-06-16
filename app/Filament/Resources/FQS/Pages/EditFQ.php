<?php

namespace App\Filament\Resources\FQS\Pages;

use App\Filament\Resources\FQS\FQResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFQ extends EditRecord
{
    protected static string $resource = FQResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
