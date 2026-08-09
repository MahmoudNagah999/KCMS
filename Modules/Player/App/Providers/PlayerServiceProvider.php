<?php

declare(strict_types=1);

namespace Modules\Player\App\Providers;

use Illuminate\Support\ServiceProvider;

class PlayerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../Database/migrations');
    }
}