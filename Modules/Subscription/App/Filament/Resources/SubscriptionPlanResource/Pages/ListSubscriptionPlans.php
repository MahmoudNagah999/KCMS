<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Filament\Resources\SubscriptionPlanResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Subscription\App\Filament\Resources\SubscriptionPlanResource;

class ListSubscriptionPlans extends ListRecords
{
    protected static string $resource = SubscriptionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}