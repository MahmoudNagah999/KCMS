<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionResource\Pages;
use Modules\PlayerSubscription\App\Models\PlayerSubscription;
use Modules\Shared\App\Enums\DiscountType;
use Modules\Shared\App\Enums\PlayerSubscriptionStatus;

class PlayerSubscriptionResource extends Resource
{
    protected static ?string $model = PlayerSubscription::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|\UnitEnum|null $navigationGroup = 'Subscriptions';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('اشتراك جديد')
                    ->schema([

                        Select::make('player_id')
                            ->label('اللاعب')
                            ->relationship(
                                name: 'player',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query
                                    ->where('club_id', Filament::getTenant()->id),
                            )
                            ->searchable()
                            ->required(),

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
                            ->label('سبب الخصم (زي: أخوة - 3 لاعبين)')
                            ->visible(fn (Get $get): bool => filled($get('discount_type')))
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('player.name')
                    ->label('اللاعب')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('plan.name')
                    ->label('الباقة')
                    ->sortable(),

                TextColumn::make('price_before_discount')
                    ->label('السعر الأصلي')
                    ->money('EGP'),

                TextColumn::make('final_price')
                    ->label('السعر النهائي')
                    ->money('EGP')
                    ->weight('bold'),

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
            ->filters([

                SelectFilter::make('status')
                    ->options(
                        collect(PlayerSubscriptionStatus::cases())
                            ->mapWithKeys(fn (PlayerSubscriptionStatus $s) => [$s->value => $s->value])
                            ->toArray()
                    ),

            ])
            ->recordActions([

                ViewAction::make(),

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

            ])
            ->toolbarActions([

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayerSubscriptions::route('/'),
            'create' => Pages\CreatePlayerSubscription::route('/create'),
            'view' => Pages\ViewPlayerSubscription::route('/{record}'),
        ];
    }
}