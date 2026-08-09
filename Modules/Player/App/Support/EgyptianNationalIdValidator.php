<?php

declare(strict_types=1);

namespace Modules\Player\App\Support;

use Carbon\Carbon;
use Modules\Shared\App\Enums\Gender;

final class EgyptianNationalIdValidator
{
    /**
     * أكواد المحافظات المصرية المعتمدة (الخانتين 8 و9 في الرقم القومي).
     */
    private const VALID_GOVERNORATE_CODES = [
        '01', '02', '03', '04', '11', '12', '13', '14', '15', '16', '17', '18', '19',
        '21', '22', '23', '24', '25', '26', '27', '28', '29', '31', '32', '33', '34',
        '35', '88',
    ];

    public static function isValid(string $nationalId): bool
    {
        if (! preg_match('/^\d{14}$/', $nationalId)) {
            return false;
        }

        $governorateCode = substr($nationalId, 7, 2);

        if (! in_array($governorateCode, self::VALID_GOVERNORATE_CODES, true)) {
            return false;
        }

        return self::birthDateFrom($nationalId) !== null;
    }

    public static function birthDateFrom(string $nationalId): ?Carbon
    {
        if (! preg_match('/^\d{14}$/', $nationalId)) {
            return null;
        }

        $century = match ((int) $nationalId[0]) {
            2 => 1900,
            3 => 2000,
            default => null,
        };

        if ($century === null) {
            return null;
        }

        $year = $century + (int) substr($nationalId, 1, 2);
        $month = (int) substr($nationalId, 3, 2);
        $day = (int) substr($nationalId, 5, 2);

        if (! checkdate($month, $day, $year)) {
            return null;
        }

        $date = Carbon::create($year, $month, $day);

        return $date->isFuture() ? null : $date;
    }

    public static function genderFrom(string $nationalId): ?Gender
    {
        if (! preg_match('/^\d{14}$/', $nationalId)) {
            return null;
        }

        return ((int) $nationalId[12]) % 2 === 0 ? Gender::FEMALE : Gender::MALE;
    }
}