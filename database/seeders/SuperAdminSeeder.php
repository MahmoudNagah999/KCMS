<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Shared\App\Enums\AdminRole;
use Modules\Shared\App\Support\Permissions\PlatformTeam;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        PlatformTeam::activate();
        $user = User::updateOrCreate(
            ['email' => env('SUPER_ADMIN_EMAIL', 'admin@kcms.test')],
            [
                'name' => 'Super Admin',
                // 'password' cast is 'hashed' on the User model, so this is
                // hashed automatically — no need for Hash::make() here.
                'password' => env('SUPER_ADMIN_PASSWORD', 'password'),
                'email_verified_at' => now(),
            ],
        );

        // syncRoles (not assignRole) so re-running the seeder can't stack
        // duplicate role rows if this ever runs while a team context is set.
        $user->syncRoles(AdminRole::SUPER_ADMIN->value);
    }
}