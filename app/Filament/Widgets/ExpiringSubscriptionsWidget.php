<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Modules\Shared\App\Enums\SubscriptionStatus;
use Modules\Subscription\App\Models\Subscription;

class ExpiringSubscriptionsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getTableHeading(): ?string
    {
        return __('widgets::dashboard.admin.expiring_subscriptions.heading');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Subscription::query()
                    ->where('status', SubscriptionStatus::ACTIVE->value)
                    ->whereBetween('ends_at', [now(), now()->addDays(7)])
                    ->with(['club', 'plan'])
            )
            ->columns([

                TextColumn::make('club.name')
                    ->label(__('widgets::dashboard.admin.expiring_subscriptions.column.club')),

                TextColumn::make('plan.name')
                    ->label(__('widgets::dashboard.admin.expiring_subscriptions.column.plan')),

                TextColumn::make('ends_at')
                    ->label(__('widgets::dashboard.admin.expiring_subscriptions.column.ends_at'))
                    ->date()
                    ->color('danger')
                    ->sortable(),

            ])
            ->defaultSort('ends_at')
            ->paginated(false);
    }
}