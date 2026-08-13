<?php

declare(strict_types=1);

namespace App\Policies;

use Modules\Shared\App\Support\Permissions\CrudPolicy;

class RolePolicy extends CrudPolicy
{
    protected function resource(): string
    {
        return 'role';
    }
}