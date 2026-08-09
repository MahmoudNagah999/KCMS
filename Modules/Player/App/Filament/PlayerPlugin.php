<?php

declare(strict_types=1);

namespace Modules\Player\App\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\Player\App\Filament\Resources\PlayerResource;

class PlayerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'player';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                PlayerResource::class,
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