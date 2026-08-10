<?php

declare(strict_types=1);

namespace Modules\Player\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Club\App\Models\Club;
use Modules\PlayerSubscription\App\Models\PlayerSubscription;
use Modules\Shared\App\Enums\BeltRank;
use Modules\Shared\App\Enums\Gender;

class Player extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'club_id',
        'name',
        'national_id',
        'birth_date',
        'gender',
        'belt',
        'federation_number',
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'gender' => Gender::class,
            'belt' => BeltRank::class,
        ];
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(PlayerSubscription::class);
    }
}