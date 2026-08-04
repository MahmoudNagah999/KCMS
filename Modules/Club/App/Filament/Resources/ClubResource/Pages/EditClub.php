<?php

declare(strict_types=1);

namespace Modules\Club\App\Filament\Resources\ClubResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Club\App\Filament\Resources\ClubResource;

class EditClub extends EditRecord
{
    protected static string $resource = ClubResource::class;


    protected function getHeaderActions(): array
    {
        return [

            Actions\DeleteAction::make(),

        ];
    }
}