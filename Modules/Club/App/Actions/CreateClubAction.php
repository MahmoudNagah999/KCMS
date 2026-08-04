<?php

declare(strict_types=1);

namespace Modules\Club\App\Actions;

use Modules\Club\App\DTOs\CreateClubData;
use Modules\Club\App\Models\Club;

final class CreateClubAction
{
    public function execute(CreateClubData $data): Club
    {
        return Club::create($data->toArray());
    }
}