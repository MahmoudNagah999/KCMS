<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\PlayerSubscription\App\Console\Commands\ExpirePlayerSubscriptionsCommand;
use Modules\PlayerSubscription\App\Models\PlayerSubscription;
use Modules\PlayerSubscription\App\Models\PlayerSubscriptionPlan;
use Modules\PlayerSubscription\App\Policies\PlayerSubscriptionPlanPolicy;
use Modules\PlayerSubscription\App\Policies\PlayerSubscriptionPolicy;

class PlayerSubscriptionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../Database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'player-subscription');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ExpirePlayerSubscriptionsCommand::class,
            ]);
        }

        Gate::policy(PlayerSubscriptionPlan::class, PlayerSubscriptionPlanPolicy::class);
        Gate::policy(PlayerSubscription::class, PlayerSubscriptionPolicy::class);
    }
}