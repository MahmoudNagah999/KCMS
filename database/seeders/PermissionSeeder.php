<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shared\App\Support\Permissions\PermissionRegistry;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PermissionRegistry::all() as $permission) {
            Permission::findOrCreate($permission, 'web');
        }
    }
}