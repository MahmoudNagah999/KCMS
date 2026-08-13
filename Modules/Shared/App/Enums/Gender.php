<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
{
    case MALE = 'male';

    case FEMALE = 'female';

    public function getLabel(): ?string
    {
        return __("shared::enums.gender.{$this->value}");
    }
}