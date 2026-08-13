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
                ->label(__('player::import.action.import_pdf'))
                ->icon('heroicon-o-arrow-up-tray')
                ->schema([
                    FileUpload::make('pdf_file')
                        ->label(__('player::import.field.pdf_file'))
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
                ->label(__('player::import.action.import_report'))
                ->modalHeading(__('player::import.modal.heading'))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel(__('player::import.modal.close'))
                ->modalContent(fn (): HtmlString => $this->renderImportReport())
                ->hidden(),

            CreateAction::make(),

        ];
    }

    protected function renderImportReport(): HtmlString
    {
        $summary = sprintf(
            '<p class="mb-4">%s</p>',
            __('player::import.summary', [
                'created' => $this->importCreatedCount,
                'updated' => $this->importUpdatedCount,
            ]),
        );

        if (empty($this->importSkippedRows)) {
            return new HtmlString($summary.'<p>'.__('player::import.no_skipped').'</p>');
        }

        $rows = collect($this->importSkippedRows)
            ->map(fn (array $row): string => sprintf(
                '<tr class="border-b"><td class="px-3 py-2">%d</td><td class="px-3 py-2">%s</td><td class="px-3 py-2">%s</td></tr>',
                $row['row_number'],
                e($row['name']),
                e($row['reason']),
            ))
            ->implode('');

        $thRowNumber = __('player::import.table.row_number');
        $thName = __('player::import.table.name');
        $thReason = __('player::import.table.reason');

        $table = <<<HTML
            <table class="w-full text-sm text-start">
                <thead>
                    <tr class="border-b">
                        <th class="px-3 py-2 text-start">{$thRowNumber}</th>
                        <th class="px-3 py-2 text-start">{$thName}</th>
                        <th class="px-3 py-2 text-start">{$thReason}</th>
                    </tr>
                </thead>
                <tbody>{$rows}</tbody>
            </table>
        HTML;

        return new HtmlString(
            $summary
            .'<p class="mb-2">'.__('player::import.skipped_count', ['count' => count($this->importSkippedRows)]).'</p>'
            .$table
        );
    }
}