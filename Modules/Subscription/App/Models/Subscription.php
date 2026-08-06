<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Club\App\Models\Club;
use Modules\Shared\App\Enums\SubscriptionStatus;

class Subscription extends Model
{
    protected $fillable = [
        'club_id',
        'subscription_plan_id',
        'price_paid',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price_paid' => 'decimal:2',
            'starts_at' => 'date',
            'ends_at' => 'date',
            'status' => SubscriptionStatus::class,
        ];
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}