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

            Stat::make('إجمالي الأندية', Club::query()->count())
                ->icon('heroicon-o-building-office-2')
                ->color('primary'),

            Stat::make('الأندية النشطة', Club::query()
                ->where('club_status', ClubStatus::ACTIVE->value)
                ->count())
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('اشتراكات نشطة', Subscription::query()
                ->where('status', SubscriptionStatus::ACTIVE->value)
                ->count())
                ->icon('heroicon-o-credit-card')
                ->color('success'),

            Stat::make('أندية Trial', Club::query()
                ->where('subscription_status', SubscriptionStatus::TRIAL->value)
                ->count())
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('إيراد الاشتراكات النشطة', number_format((float) $activeRevenue, 2).' EGP')
                ->icon('heroicon-o-banknotes')
                ->color('primary'),

        ];
    }
}