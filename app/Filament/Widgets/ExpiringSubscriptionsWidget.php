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

    protected static ?string $heading = 'اشتراكات هتنتهي خلال 7 أيام';

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
                    ->label('النادي'),

                TextColumn::make('plan.name')
                    ->label('الباقة'),

                TextColumn::make('ends_at')
                    ->label('تاريخ الانتهاء')
                    ->date()
                    ->color('danger')
                    ->sortable(),

            ])
            ->defaultSort('ends_at')
            ->paginated(false);
    }
}