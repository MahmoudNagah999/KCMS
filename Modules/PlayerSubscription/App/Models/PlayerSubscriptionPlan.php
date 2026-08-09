<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Club\App\Models\Club;
use Modules\Shared\App\Enums\PlanBillingType;

class PlayerSubscriptionPlan extends Model
{
    protected $fillable = [
        'club_id',
        'name',
        'billing_type',
        'price',
        'duration_days',
        'sessions_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'billing_type' => PlanBillingType::class,
            'price' => 'decimal:2',
            'duration_days' => 'integer',
            'sessions_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(PlayerSubscription::class, 'player_subscription_plan_id');
    }
}