<?php

declare(strict_types=1);

namespace Modules\Shared\App\Support\Permissions;

/**
 * Central, code-derived registry of every permission in KCMS.
 *
 * This replaces the old FR-docs-based permission seeder: permissions are
 * derived from the actual Filament resources that exist in each panel,
 * so adding/removing a resource is the only thing needed to keep
 * permissions in sync.
 */
final class PermissionRegistry
{
    /**
     * Resources managed from the Admin Dashboard.
     *
     * @return PermissionDefinition[]
     */
    public static function adminResources(): array
    {
        return [
            new PermissionDefinition('club', softDeletes: true),
            new PermissionDefinition('subscription_plan'),
            new PermissionDefinition('user'),
            new PermissionDefinition('role'),
        ];
    }

    /**
     * Resources managed from the Club Dashboard.
     *
     * @return PermissionDefinition[]
     */
    public static function clubResources(): array
    {
        return [
            new PermissionDefinition('player', softDeletes: true),
            new PermissionDefinition('player_subscription_plan'),
            new PermissionDefinition('player_subscription'),
        ];
    }

    /**
     * Permissions that don't follow the standard CRUD shape.
     *
     * - view_any_permission / view_permission: permissions are code-derived and
     *   read-only in the UI, so no create/update/delete permissions exist for them.
     * - manage_club_users: covers attach/detach/edit-role on the club's
     *   UsersRelationManager (owner-only staff management).
     *
     * @return string[]
     */
    public static function extraPermissions(): array
    {
        return [
            'view_any_permission',
            'view_permission',
            'manage_club_users',
        ];
    }

    /**
     * @return string[] every permission name that should exist in the database
     */
    public static function all(): array
    {
        return [
            ...self::flatten(self::adminResources()),
            ...self::flatten(self::clubResources()),
            ...self::extraPermissions(),
        ];
    }

    /**
     * @param  PermissionDefinition[]  $definitions
     * @return string[]
     */
    private static function flatten(array $definitions): array
    {
        $permissions = [];

        foreach ($definitions as $definition) {
            $permissions = [...$permissions, ...$definition->permissions()];
        }

        return $permissions;
    }
}