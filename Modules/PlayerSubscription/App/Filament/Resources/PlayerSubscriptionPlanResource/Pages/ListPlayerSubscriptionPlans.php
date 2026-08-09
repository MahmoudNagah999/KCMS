<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionPlanResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionPlanResource;

class ListPlayerSubscriptionPlans extends ListRecords
{
    protected static string $resource = PlayerSubscriptionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}