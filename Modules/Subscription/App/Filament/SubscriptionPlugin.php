<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\Subscription\App\Filament\Resources\SubscriptionPlanResource;

class SubscriptionPlugin implements Plugin
{
    public function getId(): string
    {
        return 'subscription';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                SubscriptionPlanResource::class,
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