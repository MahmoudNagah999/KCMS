<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Policies;

use Modules\Shared\App\Support\Permissions\CrudPolicy;

class SubscriptionPlanPolicy extends CrudPolicy
{
    protected function resource(): string
    {
        return 'subscription_plan';
    }
}