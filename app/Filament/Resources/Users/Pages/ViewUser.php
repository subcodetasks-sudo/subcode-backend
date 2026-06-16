<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

               Action::make('verifyMobile')
                ->label(__('admin.mobile_verified_at'))
                ->color('success')
                ->visible(fn ($record) => $record->mobile_verified_at === null)
                ->action(function (array $data, $record) {
                    $record->update([
                        'mobile_verified_at' => $data['mobile_verified_at'] ?? now(),
                    ]);

                    Notification::make()
                        ->title(__('admin.success'))
                        ->body(__('admin.mobile_verified_success'))
                        ->success()
                        ->send();
                })
                ->button()
                ->icon('heroicon-o-check')
                ->form([
                    DateTimePicker::make('mobile_verified_at')
                        ->label(__('admin.mobile_verified_at'))
                        ->required(),
                ])
                ->requiresConfirmation(),
                
        ];
    }
}
