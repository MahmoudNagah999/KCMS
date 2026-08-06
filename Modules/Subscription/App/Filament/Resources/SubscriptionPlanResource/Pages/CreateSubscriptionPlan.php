<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Filament\Resources\SubscriptionPlanResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Subscription\App\Filament\Resources\SubscriptionPlanResource;

class CreateSubscriptionPlan extends CreateRecord
{
    protected static string $resource = SubscriptionPlanResource::class;
}