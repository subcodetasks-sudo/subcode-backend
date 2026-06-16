<?php

namespace App\Filament\Pages;

use App\Filament\Schemas\AboutUsForm;
use App\Models\AboutUs as AboutUsModel;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Icons\Heroicon;

class AboutUs extends Page implements HasSchemas
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static ?string $slug = 'about-us';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.about-us';

    public ?array $data = [];

    public AboutUsModel $record;

    public static function getNavigationLabel(): string
    {
        return __('strings.aboutus');
    }

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        if (! $user) {
            return false;
        }

        return $user->can('Update:AboutUs')
            || $user->can('View:AboutUs')
            || $user->can('view:AboutUs');
    }

    public function getHeading(): string
    {
        return __('strings.aboutus');
    }

    public function mount(): void
    {
        $this->record = AboutUsModel::query()->with('meta')->firstOrCreate([]);
        $this->fillForm();
    }

    protected function getForms(): array
    {
        return [
            'form',
        ];
    }

    public function form(Schema $form): Schema
    {
        return AboutUsForm::configure($form)
            ->model($this->record)
            ->statePath('data');
    }

    protected function fillForm(): void
    {
        $state = $this->record->attributesToArray();

        if ($this->record->meta) {
            $state['meta'] = collect($this->record->meta->getAttributes())
                ->except(['id', 'metaable_type', 'metaable_id', 'created_at', 'updated_at'])
                ->all();
        }

        $this->form->fill($state);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('admin.save_settings'))
                ->submit('submit'),
        ];
    }

    public function submit(): void
    {
        try {
            $data = $this->form->getState();
            $meta = $data['meta'] ?? null;
            unset($data['meta']);

            $this->record->update($data);

            if (is_array($meta)) {
                $this->record->meta()->updateOrCreate([], $meta);
            }
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('admin.updated_successfully'))
            ->send();
    }
}
