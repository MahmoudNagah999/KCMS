<?php

declare(strict_types=1);

namespace Modules\Player\App\Support;

use Modules\Shared\App\Enums\BeltRank;

final class BeltMapper
{
    /**
     * Maps a fixed (already un-reversed) Arabic belt string like
     * "دان - 1" or "أصفر - 10" to a BeltRank enum value.
     * Returns null if the string doesn't match a known pattern
     * (e.g. "اسود ناشئين" — a special juniors category with no dan level).
     */
    public static function map(string $beltText): ?BeltRank
    {
        $normalized = trim($beltText);

        // White belt has no number
        if (str_contains($normalized, 'أبيض') || str_contains($normalized, 'ابيض')) {
            return BeltRank::WHITE;
        }

        // Special junior black belt category (no dan level)
        if (str_contains($normalized, 'اسود') && str_contains($normalized, 'ناشئين')) {
            return BeltRank::BLACK_JUNIOR;
        }

        if (! preg_match('/(\d+)/', $normalized, $numberMatch)) {
            return null;
        }

        $level = (int) $numberMatch[1];

        $colorMap = [
            'أصفر' => 'yellow', 'اصفر' => 'yellow',
            'برتقال' => 'orange',
            'أخضر' => 'green', 'اخضر' => 'green',
            'أزرق' => 'blue', 'ازرق' => 'blue',
            'بنى' => 'brown', 'بني' => 'brown',
            'دان' => 'black-dan',
        ];

        foreach ($colorMap as $arabic => $prefix) {
            if (str_contains($normalized, $arabic)) {
                $enumValue = $prefix === 'black-dan'
                    ? "black-dan-{$level}"
                    : "{$prefix}-{$level}";

                return BeltRank::tryFrom($enumValue);
            }
        }

        return null;
    }
}