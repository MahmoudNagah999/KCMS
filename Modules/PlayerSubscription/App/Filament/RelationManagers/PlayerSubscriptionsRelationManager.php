<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Modules\PlayerSubscription\App\Actions\CreatePlayerSubscriptionAction;
use Modules\PlayerSubscription\App\DTOs\CreatePlayerSubscriptionData;
use Modules\PlayerSubscription\App\Models\PlayerSubscription;
use Modules\Shared\App\Enums\DiscountType;
use Modules\Shared\App\Enums\PlayerSubscriptionStatus;

class PlayerSubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    protected static ?string $title = 'الاشتراكات';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make()
                    ->schema([

                        Select::make('player_subscription_plan_id')
                            ->label('الباقة')
                            ->relationship(
                                name: 'plan',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query
                                    ->where('club_id', Filament::getTenant()->id)
                                    ->where('is_active', true),
                            )
                            ->searchable()
                            ->required(),

                        DatePicker::make('starts_at')
                            ->label('تاريخ البداية')
                            ->default(now())
                            ->required(),

                        Select::make('discount_type')
                            ->label('نوع الخصم')
                            ->options([
                                DiscountType::PERCENTAGE->value => 'نسبة %',
                                DiscountType::FIXED_AMOUNT->value => 'مبلغ ثابت',
                            ])
                            ->native(false)
                            ->live(),

                        TextInput::make('discount_value')
                            ->label('قيمة الخصم')
                            ->numeric()
                            ->visible(fn (Get $get): bool => filled($get('discount_type')))
                            ->required(fn (Get $get): bool => filled($get('discount_type'))),

                        Textarea::make('discount_reason')
                            ->label('سبب الخصم')
                            ->visible(fn (Get $get): bool => filled($get('discount_type')))
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([

                TextColumn::make('plan.name')
                    ->label('الباقة'),

                TextColumn::make('final_price')
                    ->label('السعر')
                    ->money('EGP'),

                TextColumn::make('starts_at')
                    ->label('البداية')
                    ->date(),

                TextColumn::make('ends_at')
                    ->label('النهاية')
                    ->date()
                    ->placeholder('—'),

                TextColumn::make('sessions_remaining')
                    ->label('حصص متبقية')
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (PlayerSubscriptionStatus $state): string => match ($state) {
                        PlayerSubscriptionStatus::ACTIVE => 'success',
                        PlayerSubscriptionStatus::EXPIRED => 'warning',
                        PlayerSubscriptionStatus::CANCELLED => 'danger',
                    }),

            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([

                CreateAction::make()
                    ->label('اشتراك جديد')
                    ->using(function (array $data): Model {
                        return app(CreatePlayerSubscriptionAction::class)->execute(
                            CreatePlayerSubscriptionData::fromArray([
                                'club_id' => Filament::getTenant()->id,
                                'player_id' => $this->getOwnerRecord()->id,
                                'player_subscription_plan_id' => $data['player_subscription_plan_id'],
                                'starts_at' => $data['starts_at'],
                                'discount_type' => $data['discount_type'] ?? null,
                                'discount_value' => $data['discount_value'] ?? null,
                                'discount_reason' => $data['discount_reason'] ?? null,
                            ])
                        );
                    }),

            ])
            ->recordActions([

                Action::make('cancel')
                    ->label('إلغاء')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (PlayerSubscription $record): bool => $record->status === PlayerSubscriptionStatus::ACTIVE)
                    ->action(function (PlayerSubscription $record): void {
                        $record->update(['status' => PlayerSubscriptionStatus::CANCELLED->value]);

                        Notification::make()
                            ->title('تم إلغاء الاشتراك')
                            ->success()
                            ->send();
                    }),

            ]);
    }
}