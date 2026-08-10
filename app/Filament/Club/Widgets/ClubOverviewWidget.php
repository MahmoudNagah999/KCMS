<?php

declare(strict_types=1);

namespace App\Filament\Club\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Player\App\Models\Player;
use Modules\PlayerSubscription\App\Models\PlayerSubscription;
use Modules\Shared\App\Enums\PlayerSubscriptionStatus;

class ClubOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $clubId = Filament::getTenant()->id;

        $totalPlayers = Player::query()
            ->where('club_id', $clubId)
            ->count();

        $activeSubscriptions = PlayerSubscription::query()
            ->where('club_id', $clubId)
            ->where('status', PlayerSubscriptionStatus::ACTIVE->value)
            ->count();

        $expiringSoon = PlayerSubscription::query()
            ->where('club_id', $clubId)
            ->where('status', PlayerSubscriptionStatus::ACTIVE->value)
            ->whereNotNull('ends_at')
            ->whereBetween('ends_at', [now(), now()->addDays(7)])
            ->count();

        $monthlyRevenue = PlayerSubscription::query()
            ->where('club_id', $clubId)
            ->whereMonth('starts_at', now()->month)
            ->whereYear('starts_at', now()->year)
            ->sum('final_price');

        return [

            Stat::make('إجمالي اللاعبين', $totalPlayers)
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('اشتراكات نشطة', $activeSubscriptions)
                ->icon('heroicon-o-credit-card')
                ->color('success'),

            Stat::make('هتنتهي خلال 7 أيام', $expiringSoon)
                ->icon('heroicon-o-exclamation-triangle')
                ->color($expiringSoon > 0 ? 'danger' : 'success'),

            Stat::make('إيراد الشهر ده', number_format((float) $monthlyRevenue, 2).' EGP')
                ->icon('heroicon-o-banknotes')
                ->color('primary'),

        ];
    }
}