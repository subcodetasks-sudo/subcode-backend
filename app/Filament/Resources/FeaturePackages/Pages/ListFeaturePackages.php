<?php

namespace App\Filament\Resources\FeaturePackages\Pages;

use App\Filament\Resources\FeaturePackages\FeaturePackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFeaturePackages extends ListRecords
{
    protected static string $resource = FeaturePackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
