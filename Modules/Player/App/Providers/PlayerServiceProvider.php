<?php

declare(strict_types=1);

namespace Modules\Player\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Player\App\Models\Player;
use Modules\Player\App\Policies\PlayerPolicy;

class PlayerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../Database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'player');

        Gate::policy(Player::class, PlayerPolicy::class);

    }
}