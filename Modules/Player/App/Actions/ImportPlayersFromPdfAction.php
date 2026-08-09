<?php

declare(strict_types=1);

namespace Modules\Player\App\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Player\App\DTOs\ImportPlayersReport;
use Modules\Player\App\Models\Player;
use Modules\Player\App\Support\BeltMapper;
use Modules\Player\App\Support\EgyptianNationalIdValidator;
use Modules\Player\App\Support\PlayerPdfParser;
use Modules\Shared\App\Enums\Gender;

final class ImportPlayersFromPdfAction
{
    public function __construct(
        private readonly PlayerPdfParser $parser,
    ) {}

    public function execute(string $filePath, int $clubId): ImportPlayersReport
    {
        $rows = $this->parser->parse($filePath);

        $created = [];
        $updated = [];
        $skipped = [];

        DB::transaction(function () use ($rows, $clubId, &$created, &$updated, &$skipped): void {
            foreach ($rows as $row) {

                // 1) الرقم القومي لازم يكون 14 رقم صحيح
                if (! EgyptianNationalIdValidator::isValid($row['national_id'])) {
                    $skipped[] = [
                        'row_number' => $row['row_number'],
                        'name' => $row['name'],
                        'reason' => 'الرقم القومي غير صحيح',
                    ];
                    continue;
                }

                // 2) تحويل الحزام؛ لو مش معروف نتخطى الصف
                $belt = BeltMapper::map($row['belt_raw']);

                if ($belt === null) {
                    $skipped[] = [
                        'row_number' => $row['row_number'],
                        'name' => $row['name'],
                        'reason' => "الحزام غير معروف: \"{$row['belt_raw']}\"",
                    ];
                    continue;
                }

                // 3) استنتاج الجنس من الرقم القومي (الخانة رقم 13: فردي = ذكر، زوجي = أنثى)
                $gender = EgyptianNationalIdValidator::genderFrom($row['national_id']);

                $existing = Player::withTrashed()
                    ->where('national_id', $row['national_id'])
                    ->first();

                $attributes = [
                    'name' => $row['name'],
                    'birth_date' => $row['birth_date'],
                    'gender' => $gender,
                    'belt' => $belt,
                    'federation_number' => $row['federation_number'],
                ];

                if ($existing !== null) {
                    // موجود في نادي تاني: نسيبه ونسجله كـ "يحتاج مراجعة" بدل نقل صامت
                    if ($existing->club_id !== $clubId) {
                        $skipped[] = [
                            'row_number' => $row['row_number'],
                            'name' => $row['name'],
                            'reason' => 'اللاعب مسجل بالفعل في نادي آخر — يحتاج نقل يدوي',
                        ];
                        continue;
                    }

                    $existing->update($attributes);

                    $updated[] = [
                        'row_number' => $row['row_number'],
                        'name' => $row['name'],
                    ];

                    continue;
                }

                Player::create([
                    'club_id' => $clubId,
                    'national_id' => $row['national_id'],
                    ...$attributes,
                ]);

                $created[] = [
                    'row_number' => $row['row_number'],
                    'name' => $row['name'],
                ];
            }
        });

        return new ImportPlayersReport($created, $updated, $skipped);
    }
}