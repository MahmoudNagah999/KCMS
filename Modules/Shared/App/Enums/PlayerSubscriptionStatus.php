<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PlayerSubscriptionStatus: string implements HasLabel
{
    case ACTIVE = 'active';

    case EXPIRED = 'expired';

    case CANCELLED = 'cancelled';

    public function getLabel(): ?string
    {
        return __("shared::enums.player_subscription_status.{$this->value}");
    }
}