<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

enum AdminRole: string
{
    case SUPER_ADMIN = 'super-admin';

    case ADMIN = 'admin';
}