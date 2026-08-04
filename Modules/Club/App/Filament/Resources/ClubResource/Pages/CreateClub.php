<?php

declare(strict_types=1);

namespace Modules\Club\App\Filament\Resources\ClubResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Club\App\DTOs\CreateClubData;
use Modules\Club\App\Actions\CreateClubAction;
use Modules\Club\App\Filament\Resources\ClubResource;

class CreateClub extends CreateRecord
{
    protected static string $resource = ClubResource::class;


    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        return app(CreateClubAction::class)
            ->execute(
                CreateClubData::fromArray($data)
            );
    }
}