<?php

namespace App\Providers\Filament;

use App\Filament\Club\Pages\Tenancy\RegisterClub;
use App\Http\Middleware\SetLocale;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Club\App\Models\Club;
use Filament\Pages\Dashboard;
use Modules\Player\App\Filament\PlayerPlugin;
use Modules\PlayerSubscription\App\Filament\PlayerSubscriptionPlugin;
use Filament\Navigation\MenuItem;

class ClubPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('club')
            ->path('club')
            ->login()
            ->passwordReset()
            ->profile()
            ->tenant(Club::class)
            ->tenantRegistration(RegisterClub::class)
            ->pages([
                Dashboard::class,
            ])
            ->colors([
                'primary' => Color::Blue,
            ])
            ->brandName('KCMS - Club Dashboard')
            ->discoverResources(in: app_path('Filament/Club/Resources'), for: 'App\Filament\Club\Resources')
            ->discoverPages(in: app_path('Filament/Club/Pages'), for: 'App\Filament\Club\Pages')
            ->discoverWidgets(in: app_path('Filament/Club/Widgets'), for: 'App\Filament\Club\Widgets')
            ->middleware([
                SetLocale::class,
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
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
                PlayerPlugin::make(),
                PlayerSubscriptionPlugin::make(),
            ])->userMenuItems([
                MenuItem::make()
                    ->label(fn () => app()->getLocale() === 'ar' ? 'English' : 'العربية')
                    ->url(fn () => route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar'))
                    ->icon('heroicon-o-language'),
            ]);
    }
}