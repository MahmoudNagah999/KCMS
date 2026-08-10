<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\PlayerSubscription\App\Models\PlayerSubscription;
use Modules\Shared\App\Enums\PlayerSubscriptionStatus;

class ExpirePlayerSubscriptionsCommand extends Command
{
    protected $signature = 'player-subscriptions:expire';

    protected $description = 'يحوّل حالة الاشتراكات اللي عدّى تاريخ نهايتها إلى منتهي (expired)';

    public function handle(): int
    {
        $count = PlayerSubscription::query()
            ->where('status', PlayerSubscriptionStatus::ACTIVE->value)
            ->whereNotNull('ends_at')
            ->whereDate('ends_at', '<', Carbon::today())
            ->update(['status' => PlayerSubscriptionStatus::EXPIRED->value]);

        $this->info("تم تحديث {$count} اشتراك إلى (منتهي).");

        return self::SUCCESS;
    }
}