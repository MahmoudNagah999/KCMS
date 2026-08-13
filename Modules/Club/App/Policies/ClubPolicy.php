<?php

declare(strict_types=1);

namespace Modules\Club\App\Policies;

use Modules\Shared\App\Support\Permissions\CrudPolicy;

class ClubPolicy extends CrudPolicy
{
    protected function resource(): string
    {
        return 'club';
    }
}