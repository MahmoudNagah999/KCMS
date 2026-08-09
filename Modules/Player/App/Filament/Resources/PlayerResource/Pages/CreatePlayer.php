<?php

declare(strict_types=1);

namespace Modules\Player\App\Filament\Resources\PlayerResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Player\App\Filament\Resources\PlayerResource;

class CreatePlayer extends CreateRecord
{
    protected static string $resource = PlayerResource::class;
}