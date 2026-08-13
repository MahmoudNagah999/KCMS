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

    public static function getNavigationGroup(): ?string
    {
        return __('player-subscription::resource.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('player-subscription::resource.navigation.subscriptions');
    }

    public static function getModelLabel(): string
    {
        return __('player-subscription::resource.navigation.subscriptions');
    }

    public static function getPluralModelLabel(): string
    {
        return __('player-subscription::resource.navigation.subscriptions');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('player-subscription::resource.section.new_subscription'))
                    ->schema([

                        Select::make('player_id')
                            ->label(__('player-subscription::resource.field.player'))
                            ->relationship(
                                name: 'player',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query
                                    ->where('club_id', Filament::getTenant()->id),
                            )
                            ->searchable()
                            ->required(),

                        Select::make('player_subscription_plan_id')
                            ->label(__('player-subscription::resource.field.plan'))
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
                            ->label(__('player-subscription::resource.field.starts_at'))
                            ->default(now())
                            ->required(),

                        Select::make('discount_type')
                            ->label(__('player-subscription::resource.field.discount_type'))
                            ->options(DiscountType::class)
                            ->native(false)
                            ->live(),

                        TextInput::make('discount_value')
                            ->label(__('player-subscription::resource.field.discount_value'))
                            ->numeric()
                            ->visible(fn (Get $get): bool => filled($get('discount_type')))
                            ->required(fn (Get $get): bool => filled($get('discount_type'))),

                        Textarea::make('discount_reason')
                            ->label(__('player-subscription::resource.field.discount_reason'))
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
                    ->label(__('player-subscription::resource.field.player'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('plan.name')
                    ->label(__('player-subscription::resource.field.plan'))
                    ->sortable(),

                TextColumn::make('price_before_discount')
                    ->label(__('player-subscription::resource.field.price_before_discount'))
                    ->money('EGP'),

                TextColumn::make('final_price')
                    ->label(__('player-subscription::resource.field.final_price'))
                    ->money('EGP')
                    ->weight('bold'),

                TextColumn::make('starts_at')
                    ->label(__('player-subscription::resource.field.starts_at'))
                    ->date(),

                TextColumn::make('ends_at')
                    ->label(__('player-subscription::resource.field.ends_at'))
                    ->date()
                    ->placeholder('—'),

                TextColumn::make('sessions_remaining')
                    ->label(__('player-subscription::resource.field.sessions_remaining'))
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label(__('player-subscription::resource.field.status'))
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
                    ->label(__('player-subscription::resource.field.status'))
                    ->options(PlayerSubscriptionStatus::class),

            ])
            ->recordActions([

                ViewAction::make(),

                Action::make('cancel')
                    ->label(__('player-subscription::resource.action.cancel'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (PlayerSubscription $record): bool => $record->status === PlayerSubscriptionStatus::ACTIVE)
                    ->action(function (PlayerSubscription $record): void {
                        $record->update(['status' => PlayerSubscriptionStatus::CANCELLED->value]);

                        Notification::make()
                            ->title(__('player-subscription::resource.notification.cancelled'))
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