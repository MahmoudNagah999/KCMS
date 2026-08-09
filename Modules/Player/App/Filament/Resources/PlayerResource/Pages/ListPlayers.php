<?php

declare(strict_types=1);

namespace Modules\Player\App\Filament\Resources\PlayerResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Modules\Player\App\Actions\ImportPlayersFromPdfAction;
use Modules\Player\App\DTOs\ImportPlayersReport;
use Modules\Player\App\Filament\Resources\PlayerResource;

class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;

    /**
     * @var array<int, array{row_number: int, name: string, reason: string}>
     */
    public array $importSkippedRows = [];

    public int $importCreatedCount = 0;

    public int $importUpdatedCount = 0;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('importPdf')
                ->label('استيراد من PDF')
                ->icon('heroicon-o-arrow-up-tray')
                ->schema([
                    FileUpload::make('pdf_file')
                        ->label('ملف كشف اللاعبين (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->disk('local')
                        ->directory('player-imports')
                        ->visibility('private')
                        ->required(),
                ])
                ->action(function (array $data): void {

                    $relativePath = $data['pdf_file'];
                    $absolutePath = Storage::disk('local')->path($relativePath);

                    $report = app(ImportPlayersFromPdfAction::class)->execute(
                        filePath: $absolutePath,
                        clubId: Filament::getTenant()->id,
                    );

                    Storage::disk('local')->delete($relativePath);

                    $this->importCreatedCount = $report->createdCount();
                    $this->importUpdatedCount = $report->updatedCount();
                    $this->importSkippedRows = $report->skipped;

                    $this->mountAction('importReport');
                }),

            Action::make('importReport')
                ->label('تقرير الاستيراد')
                ->modalHeading('نتيجة استيراد اللاعبين')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('إغلاق')
                ->modalContent(fn (): HtmlString => $this->renderImportReport())
                ->hidden(),

            CreateAction::make(),

        ];
    }

    protected function renderImportReport(): HtmlString
    {
        $summary = sprintf(
            '<p class="mb-4">تم إنشاء <strong>%d</strong> لاعب، وتحديث <strong>%d</strong> لاعب.</p>',
            $this->importCreatedCount,
            $this->importUpdatedCount,
        );

        if (empty($this->importSkippedRows)) {
            return new HtmlString($summary.'<p>مفيش صفوف اتخطت.</p>');
        }

        $rows = collect($this->importSkippedRows)
            ->map(fn (array $row): string => sprintf(
                '<tr class="border-b"><td class="px-3 py-2">%d</td><td class="px-3 py-2">%s</td><td class="px-3 py-2">%s</td></tr>',
                $row['row_number'],
                e($row['name']),
                e($row['reason']),
            ))
            ->implode('');

        $table = <<<HTML
            <table class="w-full text-sm text-start">
                <thead>
                    <tr class="border-b">
                        <th class="px-3 py-2 text-start">#</th>
                        <th class="px-3 py-2 text-start">الاسم</th>
                        <th class="px-3 py-2 text-start">السبب</th>
                    </tr>
                </thead>
                <tbody>{$rows}</tbody>
            </table>
        HTML;

        return new HtmlString($summary."<p class=\"mb-2\">صفوف اتخطت (".count($this->importSkippedRows)."):</p>".$table);
    }
}