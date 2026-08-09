<?php

declare(strict_types=1);

namespace Modules\Shared\App\Enums;

enum DiscountType: string
{
    case PERCENTAGE = 'percentage';

    case FIXED_AMOUNT = 'fixed_amount';
}