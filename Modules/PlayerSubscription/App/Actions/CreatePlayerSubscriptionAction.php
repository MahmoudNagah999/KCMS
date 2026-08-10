<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Player\App\Models\Player;
use Modules\PlayerSubscription\App\DTOs\CreatePlayerSubscriptionData;
use Modules\PlayerSubscription\App\Models\PlayerSubscription;
use Modules\PlayerSubscription\App\Models\PlayerSubscriptionPlan;
use Modules\Shared\App\Enums\DiscountType;
use Modules\Shared\App\Enums\PlanBillingType;
use Modules\Shared\App\Enums\PlayerSubscriptionStatus;

final class CreatePlayerSubscriptionAction
{
    public function execute(CreatePlayerSubscriptionData $data): PlayerSubscription
    {
        return DB::transaction(function () use ($data): PlayerSubscription {

            $player = Player::findOrFail($data->playerId);

            $plan = PlayerSubscriptionPlan::findOrFail($data->playerSubscriptionPlanId);

            // نلغي أي اشتراك نشط سابق لنفس اللاعب
            PlayerSubscription::query()
                ->where('player_id', $player->id)
                ->where('status', PlayerSubscriptionStatus::ACTIVE->value)
                ->update(['status' => PlayerSubscriptionStatus::CANCELLED->value]);

            $startsAt = Carbon::parse($data->startsAt);

            $priceBeforeDiscount = (float) $plan->price;

            $discountAmount = $this->calculateDiscountAmount(
                priceBeforeDiscount: $priceBeforeDiscount,
                discountType: $data->discountType,
                discountValue: $data->discountValue,
            );

            $finalPrice = max(0.0, $priceBeforeDiscount - $discountAmount);

            $endsAt = $plan->billing_type === PlanBillingType::DURATION
                ? $startsAt->copy()->addDays($plan->duration_days)
                : null;

            $sessionsRemaining = $plan->billing_type === PlanBillingType::SESSIONS
                ? $plan->sessions_count
                : null;

            return PlayerSubscription::create([
                'club_id' => $data->clubId,
                'player_id' => $player->id,
                'player_subscription_plan_id' => $plan->id,
                'price_before_discount' => $priceBeforeDiscount,
                'discount_type' => $data->discountType,
                'discount_value' => $data->discountValue,
                'discount_reason' => $data->discountReason,
                'final_price' => $finalPrice,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'sessions_remaining' => $sessionsRemaining,
                'status' => PlayerSubscriptionStatus::ACTIVE->value,
            ]);
        });
    }

    private function calculateDiscountAmount(
        float $priceBeforeDiscount,
        ?string $discountType,
        ?float $discountValue,
    ): float {
        if ($discountType === null || $discountValue === null || $discountValue <= 0) {
            return 0.0;
        }

        return match ($discountType) {
            DiscountType::PERCENTAGE->value => $priceBeforeDiscount * ($discountValue / 100),
            DiscountType::FIXED_AMOUNT->value => $discountValue,
            default => 0.0,
        };
    }
}