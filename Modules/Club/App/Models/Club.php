<?php

declare(strict_types=1);

namespace Modules\Club\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Club\Database\Factories\ClubFactory;
use Modules\Shared\App\Enums\ClubStatus;
use Modules\Shared\App\Enums\SubscriptionStatus;

class Club extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uuid',
        'code',
        'name',
        'name_en',
        'email',
        'phone',
        'logo',
        'address',
        'club_status',
        'subscription_status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'club_status' => ClubStatus::class,
            'subscription_status' => SubscriptionStatus::class,
        ];
    }

    protected static function newFactory(): ClubFactory
    {
        return ClubFactory::new();
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // TODO: Define relationships here
    // public function branches() {}
    // public function users() {}
    // public function players() {}
    // public function subscriptions() {}
}