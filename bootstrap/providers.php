<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Shared\App\Providers\SharedServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\Filament\ClubPanelProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Modules\Club\App\Providers\ClubServiceProvider::class,
    Modules\Subscription\App\Providers\SubscriptionServiceProvider::class,
    Modules\Player\App\Providers\PlayerServiceProvider::class,
    Modules\PlayerSubscription\App\Providers\PlayerSubscriptionServiceProvider::class,
];
