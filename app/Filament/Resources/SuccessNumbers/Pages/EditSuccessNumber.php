<?php

namespace App\Filament\Resources\SuccessNumbers\Pages;

use App\Filament\Resources\SuccessNumbers\SuccessNumberResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSuccessNumber extends EditRecord
{
    protected static string $resource = SuccessNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

