<?php

declare(strict_types=1);

namespace Modules\PlayerSubscription\App\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Modules\PlayerSubscription\App\Filament\Resources\PlayerSubscriptionPlanResource\Pages;
use Modules\PlayerSubscription\App\Models\PlayerSubscriptionPlan;
use Modules\Shared\App\Enums\PlanBillingType;

class PlayerSubscriptionPlanResource extends Resource
{
    protected static ?string $model = PlayerSubscriptionPlan::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    public static function getNavigationGroup(): ?string
    {
        return __('player-subscription::resource.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('player-subscription::resource.navigation.plans');
    }

    public static function getModelLabel(): string
    {
        return __('player-subscription::resource.navigation.plans');
    }

    public static function getPluralModelLabel(): string  
    {
        return __('player-subscription::resource.navigation.plans');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('player-subscription::resource.section.plan_details'))
                    ->schema([

                        TextInput::make('name')
                            ->label(__('player-subscription::resource.field.name'))
                            ->required()
                            ->maxLength(255),

                        Select::make('billing_type')
                            ->label(__('player-subscription::resource.field.billing_type'))
                            ->options([
                                PlanBillingType::DURATION->value => __('player-subscription::resource.field.billing_type_duration'),
                                PlanBillingType::SESSIONS->value => __('player-subscription::resource.field.billing_type_sessions'),
                            ])
                            ->required()
                            ->live()
                            ->native(false),

                        TextInput::make('price')
                            ->label(__('player-subscription::resource.field.price'))
                            ->numeric()
                            ->prefix('EGP')
                            ->required(),

                        TextInput::make('duration_days')
                            ->label(__('player-subscription::resource.field.duration_days'))
                            ->numeric()
                            ->required()
                            ->visible(fn (Get $get): bool => $get('billing_type') === PlanBillingType::DURATION->value),

                        TextInput::make('sessions_count')
                            ->label(__('player-subscription::resource.field.sessions_count'))
                            ->numeric()
                            ->required()
                            ->visible(fn (Get $get): bool => $get('billing_type') === PlanBillingType::SESSIONS->value),

                        Toggle::make('is_active')
                            ->label(__('player-subscription::resource.field.is_active'))
                            ->default(true),

                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label(__('player-subscription::resource.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('billing_type')
                    ->label(__('player-subscription::resource.field.billing_type'))
                    ->badge(),

                TextColumn::make('price')
                    ->label(__('player-subscription::resource.field.price'))
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('duration_days')
                    ->label(__('player-subscription::resource.field.duration_days'))
                    ->placeholder('—'),

                TextColumn::make('sessions_count')
                    ->label(__('player-subscription::resource.field.sessions_count'))
                    ->placeholder('—'),

                IconColumn::make('is_active')
                    ->label(__('player-subscription::resource.field.is_active'))
                    ->boolean(),

            ])
            ->filters([

                SelectFilter::make('billing_type')
                    ->label(__('player-subscription::resource.field.billing_type'))
                    ->options(PlanBillingType::class),

                TernaryFilter::make('is_active')
                    ->label(__('player-subscription::resource.field.is_active')),

            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListPlayerSubscriptionPlans::route('/'),
            'create' => Pages\CreatePlayerSubscriptionPlan::route('/create'),
            'edit' => Pages\EditPlayerSubscriptionPlan::route('/{record}/edit'),
        ];
    }
}