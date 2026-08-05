<?php

declare(strict_types=1);

namespace Modules\Club\App\Providers;

use Filament\Events\TenantSet;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;

class ClubServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../Database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'club');

        Event::listen(TenantSet::class, function (TenantSet $event): void {
            app(PermissionRegistrar::class)
                ->setPermissionsTeamId($event->getTenant()->getKey());
        });
    }
}