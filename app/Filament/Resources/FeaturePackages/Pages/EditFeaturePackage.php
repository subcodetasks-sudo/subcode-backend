<?php

namespace App\Filament\Resources\FeaturePackages\Pages;

use App\Filament\Resources\FeaturePackages\FeaturePackageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFeaturePackage extends EditRecord
{
    protected static string $resource = FeaturePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
