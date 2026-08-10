<?php

declare(strict_types=1);

namespace App\Filament\Club\Widgets;

use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Modules\PlayerSubscription\App\Models\PlayerSubscription;
use Modules\Shared\App\Enums\PlayerSubscriptionStatus;

class ExpiringPlayerSubscriptionsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'اشتراكات لاعبين هتنتهي خلال 7 أيام';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PlayerSubscription::query()
                    ->where('club_id', Filament::getTenant()->id)
                    ->where('status', PlayerSubscriptionStatus::ACTIVE->value)
                    ->whereNotNull('ends_at')
                    ->whereBetween('ends_at', [now(), now()->addDays(7)])
                    ->with(['player', 'plan'])
            )
            ->columns([

                TextColumn::make('player.name')
                    ->label('اللاعب'),

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