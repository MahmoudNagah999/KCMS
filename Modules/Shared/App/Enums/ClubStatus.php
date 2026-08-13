<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ClubStatus: string implements HasLabel
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';

    case SUSPENDED = 'suspended';

    public function getLabel(): ?string
    {
        return __("shared::enums.club_status.{$this->value}");
    }
}