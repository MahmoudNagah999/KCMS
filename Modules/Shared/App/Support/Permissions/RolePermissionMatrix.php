<?php

declare(strict_types=1);

namespace Modules\Shared\App\Support\Permissions;

use Modules\Shared\App\Enums\AdminRole;
use Modules\Shared\App\Enums\ClubRole;

/**
 * Default permission set per role, derived from PermissionRegistry's
 * resource definitions rather than hardcoded permission strings.
 *
 * Business rules encoded here (confirmed 2026-08):
 * - Admin Dashboard: only super-admin manages Access Control (roles/permissions).
 *   admin has full CRUD on club/subscription_plan/user, nothing on role/permission.
 * - Club Dashboard: owner has full control, including staff management.
 *   coach can view/create/update players & their subscriptions, no delete.
 *   administrative is narrower than coach: view/update only, no create.
 *   Both coach and administrative only ever view subscription plans (pricing).
 */
final class RolePermissionMatrix
{
    /**
     * @return string[]
     */
    public static function for(AdminRole|ClubRole $role): array
    {
        return match (true) {
            $role instanceof AdminRole => self::forAdminRole($role),
            $role instanceof ClubRole => self::forClubRole($role),
        };
    }

    private static function forAdminRole(AdminRole $role): array
    {
        [$club, $subscriptionPlan, $user, $roleResource] = PermissionRegistry::adminResources();

        return match ($role) {
            AdminRole::SUPER_ADMIN => [
                ...$club->permissions(),
                ...$subscriptionPlan->permissions(),
                ...$user->permissions(),
                ...$roleResource->permissions(),
                'view_any_permission',
                'view_permission',
                'manage_club_subscriptions',
                'manage_club_users',
            ],

            AdminRole::ADMIN => [
                ...$club->permissions(),
                ...$subscriptionPlan->permissions(),
                ...$user->permissions(),
                'manage_club_subscriptions',
                'manage_club_users',
                // no role/permission access — Access Control is super-admin only
            ],
        };
    }

    private static function forClubRole(ClubRole $role): array
    {
        [$player, $playerSubscriptionPlan, $playerSubscription] = PermissionRegistry::clubResources();

        return match ($role) {
            ClubRole::OWNER => [
                ...$player->permissions(),
                ...$playerSubscriptionPlan->permissions(),
                ...$playerSubscription->permissions(),
            ],

            ClubRole::COACH => [
                ...$player->only(['view_any', 'view', 'create', 'update']),
                ...$playerSubscriptionPlan->only(['view_any', 'view']),
                ...$playerSubscription->only(['view_any', 'view', 'create', 'update']),
            ],

            ClubRole::ADMINISTRATIVE => [
                ...$player->only(['view_any', 'view', 'update']),
                ...$playerSubscriptionPlan->only(['view_any', 'view']),
                ...$playerSubscription->only(['view_any', 'view', 'update']),
            ],
        };
    }
}