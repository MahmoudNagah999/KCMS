<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionResource\Pages;

use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Modules\PlayerSubscription\App\Actions\CreatePlayerSubscriptionAction;
use Modules\PlayerSubscription\App\DTOs\CreatePlayerSubscriptionData;
use Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionResource;

class CreatePlayerSubscription extends CreateRecord
{
    protected static string $resource = PlayerSubscriptionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return app(CreatePlayerSubscriptionAction::class)->execute(
            CreatePlayerSubscriptionData::fromArray([
                'club_id' => Filament::getTenant()->id,
                'player_id' => $data['player_id'],
                'player_subscription_plan_id' => $data['player_subscription_plan_id'],
                'starts_at' => $data['starts_at'],
                'discount_type' => $data['discount_type'] ?? null,
                'discount_value' => $data['discount_value'] ?? null,
                'discount_reason' => $data['discount_reason'] ?? null,
            ])
        );
    }
}