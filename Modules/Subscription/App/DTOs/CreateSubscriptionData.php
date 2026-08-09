<?php

declare(strict_types=1);

namespace Modules\Subscription\App\DTOs;

final class CreateSubscriptionData
{
    public function __construct(
        public readonly int $clubId,
        public readonly int $subscriptionPlanId,
        public readonly string $startsAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            clubId: (int) $data['club_id'],
            subscriptionPlanId: (int) $data['subscription_plan_id'],
            startsAt: $data['starts_at'],
        );
    }
}