<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

enum PlanBillingType: string
{
    case DURATION = 'duration';

    case SESSIONS = 'sessions';
}