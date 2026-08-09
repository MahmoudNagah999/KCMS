<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

enum PlayerSubscriptionStatus: string
{
    case ACTIVE = 'active';

    case EXPIRED = 'expired';

    case CANCELLED = 'cancelled';
}