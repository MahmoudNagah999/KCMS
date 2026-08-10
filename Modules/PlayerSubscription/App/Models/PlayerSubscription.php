<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Club\App\Models\Club;
use Modules\Player\App\Models\Player;
use Modules\Shared\App\Enums\DiscountType;
use Modules\Shared\App\Enums\PlayerSubscriptionStatus;

class PlayerSubscription extends Model
{
    protected $fillable = [
        'club_id',
        'player_id',
        'player_subscription_plan_id',
        'price_before_discount',
        'discount_type',
        'discount_value',
        'discount_reason',
        'final_price',
        'starts_at',
        'ends_at',
        'sessions_remaining',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price_before_discount' => 'decimal:2',
            'discount_type' => DiscountType::class,
            'discount_value' => 'decimal:2',
            'final_price' => 'decimal:2',
            'starts_at' => 'date',
            'ends_at' => 'date',
            'sessions_remaining' => 'integer',
            'status' => PlayerSubscriptionStatus::class,
        ];
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(PlayerSubscriptionPlan::class, 'player_subscription_plan_id');
    }
}