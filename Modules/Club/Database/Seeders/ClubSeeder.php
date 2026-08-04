<?php

declare(strict_types=1);

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Club\App\Models\Club;
use Modules\Shared\App\Enums\ClubStatus;
use Modules\Shared\App\Enums\SubscriptionStatus;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
         Club::factory()
            ->count(10)
            ->active()
            ->create();


        Club::factory()
            ->suspended()
            ->create();
    }
}