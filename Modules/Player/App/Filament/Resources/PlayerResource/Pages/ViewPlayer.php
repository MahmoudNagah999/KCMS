<?php

declare(strict_types=1);

namespace Modules\Player\App\Filament\Resources\PlayerResource\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Modules\Player\App\Filament\Resources\PlayerResource;

class ViewPlayer extends ViewRecord
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}