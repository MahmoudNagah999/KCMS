<?php

declare(strict_types=1);

namespace Modules\Shared\App\Support\Permissions;

/**
 * Describes the standard set of CRUD permissions generated for a single
 * Filament resource (e.g. "club", "player"). This is the single source of
 * truth for permission naming across the app — nothing else should hardcode
 * permission strings.
 */
final class PermissionDefinition
{
    /**
     * @param  string  $resource  snake_case singular resource key, e.g. 'player'
     * @param  bool  $softDeletes  whether the underlying model uses SoftDeletes (adds restore/force_delete permissions)
     */
    public function __construct(
        public readonly string $resource,
        public readonly bool $softDeletes = false,
    ) {}

    /**
     * @return string[]
     */
    public function actions(): array
    {
        $actions = [
            'view_any',
            'view',
            'create',
            'update',
            'delete',
            'delete_any',
        ];

        if ($this->softDeletes) {
            $actions = [
                ...$actions,
                'restore',
                'restore_any',
                'force_delete',
                'force_delete_any',
            ];
        }

        return $actions;
    }

    /**
     * @return string[] fully qualified permission names, e.g. ['view_any_player', 'view_player', ...]
     */
    public function permissions(): array
    {
        return array_map(
            fn (string $action): string => "{$action}_{$this->resource}",
            $this->actions(),
        );
    }

    public function permission(string $action): string
    {
        return "{$action}_{$this->resource}";
    }

    /**
     * Permission strings for a subset of this resource's actions.
     * Any action not valid for this resource (e.g. 'restore' on a
     * non-soft-deletable resource) is silently ignored.
     *
     * @param  string[]  $actions
     * @return string[]
     */
    public function only(array $actions): array
    {
        return array_map(
            fn (string $action): string => $this->permission($action),
            array_values(array_intersect($actions, $this->actions())),
        );
    }
}