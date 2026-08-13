<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PlanBillingType: string implements HasLabel
{
    case DURATION = 'duration';

    case SESSIONS = 'sessions';

    public function getLabel(): ?string
    {
        return __("shared::enums.plan_billing_type.{$this->value}");
    }
}