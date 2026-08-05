<?php

namespace App\Providers\Filament;

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

class ClubPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('club')
            ->path('club')
            ->login()
            ->tenant(Club::class)
            ->pages([
                Dashboard::class,
            ])
            ->colors([
                'primary' => Color::Blue,
            ])
            ->brandName('Club Dashboard')
            ->discoverResources(in: app_path('Filament/Club/Resources'), for: 'App\Filament\Club\Resources')
            ->discoverPages(in: app_path('Filament/Club/Pages'), for: 'App\Filament\Club\Pages')
            ->discoverWidgets(in: app_path('Filament/Club/Widgets'), for: 'App\Filament\Club\Widgets')
            ->middleware([
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
            ]);
    }
}