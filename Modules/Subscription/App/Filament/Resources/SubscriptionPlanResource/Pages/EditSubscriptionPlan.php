<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Filament\Resources\SubscriptionPlanResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Subscription\App\Filament\Resources\SubscriptionPlanResource;

class EditSubscriptionPlan extends EditRecord
{
    protected static string $resource = SubscriptionPlanResource::class;
}