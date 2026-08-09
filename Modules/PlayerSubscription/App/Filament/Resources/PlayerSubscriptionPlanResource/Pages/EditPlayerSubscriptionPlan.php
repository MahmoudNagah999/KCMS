<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionPlanResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionPlanResource;

class EditPlayerSubscriptionPlan extends EditRecord
{
    protected static string $resource = PlayerSubscriptionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}