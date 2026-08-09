<?php

declare(strict_types=1);

namespace Modules\Player\App\Support;

use Smalot\PdfParser\Parser;

final class PlayerPdfParser
{
    /**
     * Matches a data row anywhere in a whitespace-normalized text blob (not line-anchored,
     * since PDF text-extraction line breaks don't reliably correspond to table rows).
     * Reading order: belt_date | belt | season_reg_date | [classification] registration_type
     *                | birth_date | national_id | name | file_number | index
     */
    private const ROW_PATTERN = '/(\d{4}\/\d{2}\/\d{2})\s+(.+?)\s+(\d{4}\/\d{2}\/\d{2})\s+.+?\s+(\d{4}\/\d{2}\/\d{2})\s+(\d{14})\s+(.+?)\s+(\d+)\s+(\d+)(?=\s|$)/u';

    /**
     * @return array<int, array{
     *     row_number: int,
     *     name: string,
     *     national_id: string,
     *     birth_date: string,
     *     federation_number: string,
     *     belt_raw: string,
     * }>
     */
   public function parse(string $filePath): array
    {
        $parser = new Parser();

        $pdf = $parser->parseFile($filePath);

        $rows = [];

        foreach ($pdf->getPages() as $page) {

            $rawText = $page->getText();

            // تنضيف أي bytes غير صحيحة كـ UTF-8 (بتحصل أحيانًا بسبب مشاكل ترميز الخطوط جوه الـ PDF)
            $cleanText = iconv('UTF-8', 'UTF-8//IGNORE', $rawText);

            $blob = preg_replace('/\s+/', ' ', $cleanText);

            if ($blob === null) {
                continue;
            }

            preg_match_all(self::ROW_PATTERN, $blob, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                [, , $beltRaw, , $birthDate, $nationalId, $nameRaw, $fileNumber, $rowNumber] = $match;

                $rows[] = [
                    'row_number' => (int) $rowNumber,
                    'name' => ArabicTextFixer::fix($nameRaw),
                    'national_id' => $nationalId,
                    'birth_date' => str_replace('/', '-', $birthDate),
                    'federation_number' => $fileNumber,
                    'belt_raw' => ArabicTextFixer::fix($beltRaw),
                ];
            }
        }

        return $rows;
    }
}