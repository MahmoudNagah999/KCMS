<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

enum SubscriptionStatus: string
{
    case TRIAL = 'trial';

    case ACTIVE = 'active';

    case EXPIRED = 'expired';

    case CANCELLED = 'cancelled';
}