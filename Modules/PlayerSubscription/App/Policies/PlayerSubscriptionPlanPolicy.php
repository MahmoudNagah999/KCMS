<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Policies;

use Modules\Shared\App\Support\Permissions\CrudPolicy;

class PlayerSubscriptionPlanPolicy extends CrudPolicy
{
    protected function resource(): string
    {
        return 'player_subscription_plan';
    }
}