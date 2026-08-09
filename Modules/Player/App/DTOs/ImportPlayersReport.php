<?php

declare(strict_types=1);

namespace Modules\Player\App\DTOs;

final class ImportPlayersReport
{
    /**
     * @param array<int, array{row_number: int, name: string}> $created
     * @param array<int, array{row_number: int, name: string}> $updated
     * @param array<int, array{row_number: int, name: string, reason: string}> $skipped
     */
    public function __construct(
        public readonly array $created = [],
        public readonly array $updated = [],
        public readonly array $skipped = [],
    ) {}

    public function createdCount(): int
    {
        return count($this->created);
    }

    public function updatedCount(): int
    {
        return count($this->updated);
    }

    public function skippedCount(): int
    {
        return count($this->skipped);
    }
}