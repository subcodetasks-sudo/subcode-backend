<?php

namespace App\Filament\Resources\PartnerSuccesses\Pages;

use App\Filament\Resources\PartnerSuccesses\PartnerSuccessResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPartnerSuccess extends EditRecord
{
    protected static string $resource = PartnerSuccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
