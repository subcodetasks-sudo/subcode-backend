<?php

namespace App\Filament\Resources\FeaturePackages\Pages;

use App\Filament\Resources\FeaturePackages\FeaturePackageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFeaturePackage extends ViewRecord
{
    protected static string $resource = FeaturePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
