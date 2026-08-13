<?php

declare(strict_types=1);

namespace Modules\Club\App\Filament\Resources\ClubResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Modules\Shared\App\Enums\SubscriptionStatus;
use Modules\Subscription\App\DTOs\CreateSubscriptionData;
use Modules\Subscription\App\Actions\CreateSubscriptionAction;
use Modules\Subscription\App\Models\Subscription;
use Modules\Subscription\App\Models\SubscriptionPlan;
use Filament\Actions\CreateAction;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    public function form(Schema $schema): Schema 
    {
        return $schema
            ->components([

                Select::make('subscription_plan_id')
                    ->label(__('subscription::resource.field.plan'))
                    ->options(SubscriptionPlan::query()->where('is_active', true)->pluck('name', 'id'))
                    ->required(),

                DatePicker::make('starts_at')
                    ->label(__('subscription::resource.field.starts_at'))
                    ->required()
                    ->default(now()),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([

                TextColumn::make('plan.name')
                    ->label(__('subscription::resource.field.plan')),

                TextColumn::make('price_paid')
                    ->label(__('subscription::resource.field.price_paid'))
                    ->money('EGP'),

                TextColumn::make('starts_at')
                    ->label(__('subscription::resource.field.starts_at'))
                    ->date(),

                TextColumn::make('ends_at')
                    ->label(__('subscription::resource.field.ends_at'))
                    ->date(),

                TextColumn::make('status')
                    ->label(__('subscription::resource.field.status'))
                    ->badge(),

            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->using(function (array $data): Subscription {
                        return app(CreateSubscriptionAction::class)->execute(
                            CreateSubscriptionData::fromArray([
                                'club_id' => $this->getOwnerRecord()->getKey(),
                                'subscription_plan_id' => $data['subscription_plan_id'],
                                'starts_at' => Carbon::parse($data['starts_at'])->toDateString(),
                            ])
                        );
                    }),
            ]);
    }
}