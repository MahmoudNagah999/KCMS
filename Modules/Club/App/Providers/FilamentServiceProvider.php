<?php

declare(strict_types=1);

namespace Modules\Club\App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Modules\Club\App\Filament\Resources\ClubResource;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {

            Filament::getCurrentPanel()
                ->resources([
                    ClubResource::class,
                ]);

        });
    }
}