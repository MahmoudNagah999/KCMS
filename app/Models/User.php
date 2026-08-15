<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Modules\Club\App\Models\Club;
use Modules\Shared\App\Enums\AdminRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Shared\App\Support\Permissions\PlatformTeam;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class, 'club_user');
    }

    public function getTenants(Panel $panel): array|\Illuminate\Support\Collection
    {
        return $this->clubs;
    }

    public function canAccessTenant(\Illuminate\Database\Eloquent\Model $tenant): bool
    {
        return $this->clubs()->whereKey($tenant->getKey())->exists();
    }

    /**
     * Panel-level entry guard. This runs before a tenant is selected, so it
     * can't rely on team-scoped role checks — those are enforced per-club by
     * the CrudPolicy classes once inside a specific club (via the TenantSet
     * listener in ClubServiceProvider). Here we only gate: "is this user the
     * right *kind* of user for this panel at all".
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => (function (): bool {
                PlatformTeam::activate();

                return $this->hasRole([
                    AdminRole::SUPER_ADMIN->value,
                    AdminRole::ADMIN->value,
                ]);
            })(),
            // أي مستخدم مسجّل يقدر يدخل بانل النادي، حتى لو مالوش نادي لسه —
            // لأنه غالبًا جاي عشان يعمل أول نادي بتاعه عن طريق RegisterClub.
            // الحماية الفعلية بعد كده بتبقى على مستوى كل نادي (CrudPolicy + tenant scoping).
            'club' => true,
            default => false,
        };
    }
}