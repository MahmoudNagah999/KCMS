<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\TelescopeServiceProvider;
use Modules\Club\App\Providers\ClubServiceProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    TelescopeServiceProvider::class,
    ClubServiceProvider::class,
];
