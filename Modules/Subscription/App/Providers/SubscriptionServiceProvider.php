<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Subscription\App\Models\SubscriptionPlan;
use Modules\Subscription\App\Policies\SubscriptionPlanPolicy;

class SubscriptionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../Database/migrations');

        Gate::policy(SubscriptionPlan::class, SubscriptionPlanPolicy::class);
    }
}