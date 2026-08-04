<?php

declare(strict_types=1);

namespace Modules\Club\App\Filament\Resources\ClubResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Club\App\Filament\Resources\ClubResource;

class ListClubs extends ListRecords
{
    protected static string $resource = ClubResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}