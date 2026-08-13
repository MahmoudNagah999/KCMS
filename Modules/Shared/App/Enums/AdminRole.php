<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AdminRole: string implements HasLabel
{
    case SUPER_ADMIN = 'super-admin';

    case ADMIN = 'admin';

    public function getLabel(): ?string
    {
        return __("shared::enums.admin_role.{$this->value}");
    }
}