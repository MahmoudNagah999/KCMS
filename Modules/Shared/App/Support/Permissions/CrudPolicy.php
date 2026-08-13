<?php

declare(strict_types=1);

namespace Modules\Shared\App\Support\Permissions;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class CrudPolicy
{
    abstract protected function resource(): string;

    public function viewAny(User $user): bool
    {
        return $user->can("view_any_{$this->resource()}");
    }

    public function view(User $user, Model $model): bool
    {
        return $user->can("view_{$this->resource()}");
    }

    public function create(User $user): bool
    {
        return $user->can("create_{$this->resource()}");
    }

    public function update(User $user, Model $model): bool
    {
        return $user->can("update_{$this->resource()}");
    }

    public function delete(User $user, Model $model): bool
    {
        return $user->can("delete_{$this->resource()}");
    }

    public function deleteAny(User $user): bool
    {
        return $user->can("delete_any_{$this->resource()}");
    }

    public function restore(User $user, Model $model): bool
    {
        return $user->can("restore_{$this->resource()}");
    }

    public function restoreAny(User $user): bool
    {
        return $user->can("restore_any_{$this->resource()}");
    }

    public function forceDelete(User $user, Model $model): bool
    {
        return $user->can("force_delete_{$this->resource()}");
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can("force_delete_any_{$this->resource()}");
    }
}