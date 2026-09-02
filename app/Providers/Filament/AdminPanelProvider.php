<?php

namespace App\Providers\Filament;

use App\Filament\Pages\AboutUs;
use App\Filament\Pages\Settings;
use App\Filament\Widgets\AOverview;
use App\Filament\Widgets\MonthlyProfitChart;
use App\Support\SubcodeColors;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $this->configureTheme($panel);

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('admin')
            ->login()
            ->brandName('Subcode')
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('2.25rem')
            ->sidebarFullyCollapsibleOnDesktop(false)
            ->font(
                'Plus Jakarta Sans',
                'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap',
            )
            ->defaultThemeMode(ThemeMode::Light)
            ->darkMode(false)
            ->databaseNotifications()
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ])
            ->colors(SubcodeColors::filamentPalette())
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                Settings::class,
                AboutUs::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AOverview::class,
                MonthlyProfitChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    protected function configureTheme(Panel $panel): Panel
    {
        $compiledTheme = 'css/filament/admin-theme.css';

        if (app()->environment('local') && file_exists(public_path('build/manifest.json'))) {
            return $panel->viteTheme('resources/css/filament/admin/theme.css');
        }

        if (file_exists(public_path($compiledTheme))) {
            // Filament expects a public URL (asset()), not a filesystem path (public_path()).
            // Using public_path() resolves to the default /css/app.css theme instead.
            return $panel->theme(asset($compiledTheme));
        }

        return $panel->viteTheme('resources/css/filament/admin/theme.css');
    }
}
