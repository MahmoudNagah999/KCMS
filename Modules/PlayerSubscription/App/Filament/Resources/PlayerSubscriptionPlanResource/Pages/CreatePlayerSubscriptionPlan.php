<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionPlanResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionPlanResource;

class CreatePlayerSubscriptionPlan extends CreateRecord
{
    protected static string $resource = PlayerSubscriptionPlanResource::class;
}