<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Club\App\Models\Club;
use Modules\Shared\App\Enums\ClubStatus;
use Modules\Shared\App\Enums\SubscriptionStatus;
use Modules\Subscription\App\Models\Subscription;

class ClubsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $activeRevenue = Subscription::query()
            ->where('status', SubscriptionStatus::ACTIVE->value)
            ->sum('price_paid');

        return [

            Stat::make(__('widgets::dashboard.admin.stat.total_clubs'), Club::query()->count())
                ->icon('heroicon-o-building-office-2')
                ->color('primary'),

            Stat::make(__('widgets::dashboard.admin.stat.active_clubs'), Club::query()
                ->where('club_status', ClubStatus::ACTIVE->value)
                ->count())
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make(__('widgets::dashboard.admin.stat.active_subscriptions'), Subscription::query()
                ->where('status', SubscriptionStatus::ACTIVE->value)
                ->count())
                ->icon('heroicon-o-credit-card')
                ->color('success'),

            Stat::make(__('widgets::dashboard.admin.stat.trial_clubs'), Club::query()
                ->where('subscription_status', SubscriptionStatus::TRIAL->value)
                ->count())
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make(__('widgets::dashboard.admin.stat.active_subscriptions_revenue'), number_format((float) $activeRevenue, 2).' EGP')
                ->icon('heroicon-o-banknotes')
                ->color('primary'),

        ];
    }
}