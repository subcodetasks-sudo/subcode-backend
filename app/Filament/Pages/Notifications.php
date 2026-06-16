<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Services\FirebaseNotificationService;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;


class Notifications extends Page implements HasSchemas
{
    use InteractsWithActions, InteractsWithForms;

    protected string $view = 'filament.pages.notifications';

    public ?string $template = null;
    public ?string $fcmToken = null;
    public bool $sendToAll = false;

    protected ?FirebaseNotificationService $firebaseNotificationService = null;

    public function mount(): void
    {
        $this->firebaseNotificationService = app(FirebaseNotificationService::class);
    }

    public function getHeading(): string
    {
        return __('admin.notifications');
    }

    public static function getNavigationGroup(): string
    {
        return __('admin.notifications');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.notifications');
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Textarea::make('template')
                    ->label(__('pages.template_notification'))
                    ->required()
                    ->rows(10)
                    ->live(),

                

                Checkbox::make('sendToAll')
                    ->label(__('pages.send_to_all_users'))
                    ->reactive(),
            ])
            ->columns(2);
    }

  public function submit(): void
{
    if (!$this->firebaseNotificationService) {
        $this->firebaseNotificationService = new FirebaseNotificationService();
    }

    try {
        $this->firebaseNotificationService->sendNotification(
            'subcode',
            $this->template,
            $this->fcmToken,
            $this->sendToAll
        );
           // Save notification in the database
            Notification::create([
                'title_ar' => 'إشعار جديد',
                'message_ar' => $this->template,
                'title_en' => 'New Notification',
                'message_en' => $this->template,
                'title_tr' => 'Yeni Bildirim',
                'message_tr' => $this->template,
            ]);
            
        Notification::make()
            ->title(__('تم أرسال الاشعار بنجاح'))
            ->success()
            ->send();
    } catch (\Exception $e) {
        Notification::make()
            ->title(__('فشل أرسال الأشعار'))
            ->body($e->getMessage())
            ->danger()
            ->send();
    }
}

}
