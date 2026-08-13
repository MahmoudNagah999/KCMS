<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ClubRole: string implements HasLabel
{
    case OWNER = 'owner';

    case COACH = 'coach';

    case ADMINISTRATIVE = 'administrative';

    public function getLabel(): ?string
    {
        return __("shared::enums.club_role.{$this->value}");
    }
}