<?php

namespace App\Providers\Filament;

use App\Http\Middleware\SetLocale;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Club\App\Filament\ClubPlugin;
use Modules\Subscription\App\Filament\SubscriptionPlugin;
use App\Http\Middleware\SetPlatformPermissionsTeam;
use Filament\Navigation\MenuItem;
use App\Filament\Admin\Pages\Auth\Login;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->passwordReset()
            ->profile()
            ->colors([
                'primary' => Color::Emerald,
            ])
            // ->brandName('KCMS - Admin Dashboard')
            ->brandLogo(asset('images/logo.svg'))
            ->darkModeBrandLogo(asset('images/logo-white.png'))
            ->brandLogoHeight('4rem')                       // اضبط الارتفاع المناسب
            ->favicon(asset('favicon.ico'))
            ->maxContentWidth('full')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                SetPlatformPermissionsTeam::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                SetLocale::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                ClubPlugin::make(),
                SubscriptionPlugin::make(),
            ])->userMenuItems([
                MenuItem::make()
                    ->label(fn () => app()->getLocale() === 'ar' ? 'English' : 'العربية')
                    ->url(fn () => route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar'))
                    ->icon('heroicon-o-language'),
            ]);
    }
}
