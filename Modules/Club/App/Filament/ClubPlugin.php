<?php

declare(strict_types=1);

namespace Modules\Club\App\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Modules\Club\App\Filament\Resources\ClubResource;

class ClubPlugin implements Plugin
{
    public function getId(): string
    {
        return 'club';
    }


    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                ClubResource::class,
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