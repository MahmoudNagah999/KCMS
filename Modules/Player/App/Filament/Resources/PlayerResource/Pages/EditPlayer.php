<?php

declare(strict_types=1);

namespace Modules\Player\App\Filament\Resources\PlayerResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Player\App\Filament\Resources\PlayerResource;

class EditPlayer extends EditRecord
{
    protected static string $resource = PlayerResource::class;
}