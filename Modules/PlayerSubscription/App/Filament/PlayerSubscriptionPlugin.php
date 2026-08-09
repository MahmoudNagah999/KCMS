<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionPlanResource;

class PlayerSubscriptionPlugin implements Plugin
{
    public function getId(): string
    {
        return 'player-subscription';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                PlayerSubscriptionPlanResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}