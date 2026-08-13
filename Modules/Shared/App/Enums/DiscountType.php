<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DiscountType: string implements HasLabel
{
    case PERCENTAGE = 'percentage';

    case FIXED_AMOUNT = 'fixed_amount';

    public function getLabel(): ?string
    {
        return __("shared::enums.discount_type.{$this->value}");
    }
}