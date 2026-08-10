<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionResource;

class ListPlayerSubscriptions extends ListRecords
{
    protected static string $resource = PlayerSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}