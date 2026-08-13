<?php

declare(strict_types=1);

namespace Modules\Player\App\Policies;

use Modules\Shared\App\Support\Permissions\CrudPolicy;

class PlayerPolicy extends CrudPolicy
{
    protected function resource(): string
    {
        return 'player';
    }
}