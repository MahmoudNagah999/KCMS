<?php

declare(strict_types=1);

namespace Modules\Shared\App\Support\Permissions;

use Spatie\Permission\PermissionRegistrar;

final class PlatformTeam
{
    public const int ID = 0;

    public static function activate(): void
    {
        app(PermissionRegistrar::class)->setPermissionsTeamId(self::ID);
    }
}