<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shared\App\Enums\AdminRole;
use Modules\Shared\App\Enums\ClubRole;
use Modules\Shared\App\Support\Permissions\RolePermissionMatrix;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (AdminRole::cases() as $role) {
            Role::findOrCreate($role->value, 'web')
                ->syncPermissions(RolePermissionMatrix::for($role));
        }

        foreach (ClubRole::cases() as $role) {
            Role::findOrCreate($role->value, 'web')
                ->syncPermissions(RolePermissionMatrix::for($role));
        }
    }
}