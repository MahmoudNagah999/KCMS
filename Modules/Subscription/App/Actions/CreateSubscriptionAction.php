<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Club\App\Models\Club;
use Modules\Shared\App\Enums\SubscriptionStatus;
use Modules\Subscription\App\DTOs\CreateSubscriptionData;
use Modules\Subscription\App\Models\Subscription;
use Modules\Subscription\App\Models\SubscriptionPlan;

final class CreateSubscriptionAction
{
    public function execute(CreateSubscriptionData $data): Subscription
    {
        return DB::transaction(function () use ($data): Subscription {

            $club = Club::findOrFail($data->clubId);

            $plan = SubscriptionPlan::findOrFail($data->subscriptionPlanId);

            // نلغي أي اشتراك نشط سابق لنفس النادي
            Subscription::query()
                ->where('club_id', $club->id)
                ->where('status', SubscriptionStatus::ACTIVE->value)
                ->update(['status' => SubscriptionStatus::CANCELLED->value]);

            $startsAt = Carbon::parse($data->startsAt);

            $subscription = Subscription::create([
                'club_id' => $club->id,
                'subscription_plan_id' => $plan->id,
                'price_paid' => $plan->price,
                'starts_at' => $startsAt,
                'ends_at' => $startsAt->copy()->addDays($plan->duration_days),
                'status' => SubscriptionStatus::ACTIVE->value,
            ]);

            $club->update([
                'subscription_status' => SubscriptionStatus::ACTIVE->value,
            ]);

            return $subscription;
        });
    }
}