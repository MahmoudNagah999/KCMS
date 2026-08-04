<?php

declare(strict_types=1);

namespace Modules\Club\App\Providers;

use Illuminate\Support\ServiceProvider;

class ClubServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../Database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'club');
    }
}