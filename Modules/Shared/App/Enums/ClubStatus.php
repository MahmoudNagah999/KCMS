<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

enum ClubStatus: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';

    case SUSPENDED = 'suspended';
}