<?php

declare(strict_types=1);

namespace Modules\Player\App\Support;

final class ArabicTextFixer
{
    /**
     * PDF text extraction reverses word order and character order for Arabic text,
     * but leaves digit sequences in their correct left-to-right order.
     * This reverses token order, and reverses characters within each token
     * UNLESS the token is purely numeric.
     */
    public static function fix(string $raw): string
    {
        $tokens = array_reverse(explode(' ', trim($raw)));

        $fixed = array_map(function (string $token): string {
            if (preg_match('/^\d+$/', $token)) {
                return $token;
            }

            $chars = mb_str_split($token);

            return implode('', array_reverse($chars));
        }, $tokens);

        return implode(' ', $fixed);
    }
}