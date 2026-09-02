<?php
namespace App\Providers;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\Redirect;
use App\Observers\RedirectObserver;
use App\Services\SocialMetaResolver;
use App\Support\UploadLimits;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SocialMetaResolver::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar', 'en', 'tr'])
                ->labels([
                    'ar' => 'اللغة العربية',
                    'en' => 'اللغة الانجليزية',
                    'tr' => 'اللغة التركية',
                ]);
        });

        TranslatableTabs::configureUsing(function (TranslatableTabs $component) {
            $component
                ->localesLabels([
                    'ar' => __('strings.ar'),
                    'en' => __('strings.en'),
                    'tr' => __('strings.tr'),
                ])
                ->locales(['ar', 'en', 'tr']);
        });

        FileUpload::configureUsing(function (FileUpload $component): void {
            $component->maxSize(UploadLimits::maxKb());
        });

        Redirect::observe(RedirectObserver::class);
    }
}