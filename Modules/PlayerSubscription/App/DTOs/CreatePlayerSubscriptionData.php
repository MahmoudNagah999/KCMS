<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\DTOs;

final class CreatePlayerSubscriptionData
{
    public function __construct(
        public readonly int $clubId,
        public readonly int $playerId,
        public readonly int $playerSubscriptionPlanId,
        public readonly string $startsAt,
        public readonly ?string $discountType = null,
        public readonly ?float $discountValue = null,
        public readonly ?string $discountReason = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            clubId: (int) $data['club_id'],
            playerId: (int) $data['player_id'],
            playerSubscriptionPlanId: (int) $data['player_subscription_plan_id'],
            startsAt: $data['starts_at'],
            discountType: $data['discount_type'] ?? null,
            discountValue: isset($data['discount_value']) && $data['discount_value'] !== ''
                ? (float) $data['discount_value']
                : null,
            discountReason: $data['discount_reason'] ?? null,
        );
    }
}