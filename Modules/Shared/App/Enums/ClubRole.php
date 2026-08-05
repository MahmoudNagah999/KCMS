<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

enum ClubRole: string
{
    case OWNER = 'owner';

    case COACH = 'coach';

    case ADMINISTRATIVE = 'administrative';
}