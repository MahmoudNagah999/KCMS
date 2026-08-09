<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Providers;

use Illuminate\Support\ServiceProvider;

class PlayerSubscriptionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../Database/migrations');
    }
}