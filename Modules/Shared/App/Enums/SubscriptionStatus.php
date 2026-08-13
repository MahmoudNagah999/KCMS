<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SubscriptionStatus: string implements HasLabel
{
    case TRIAL = 'trial';

    case ACTIVE = 'active';

    case EXPIRED = 'expired';

    case CANCELLED = 'cancelled';

    public function getLabel(): ?string
    {
        return __("shared::enums.subscription_status.{$this->value}");
    }
}