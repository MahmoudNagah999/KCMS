<?php

declare(strict_types=1);

namespace Modules\Subscription\App\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Subscription\App\Filament\Resources\SubscriptionPlanResource\Pages;
use Modules\Subscription\App\Models\SubscriptionPlan;

class SubscriptionPlanResource extends Resource
{
    protected static ?string $model = SubscriptionPlan::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    public static function getNavigationGroup(): ?string
    {
        return __('subscription::resource.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('subscription::resource.navigation.plans');
    }

    public static function getModelLabel(): string
    {
        return __('subscription::resource.navigation.plans');
    }

    public static function getPluralModelLabel(): string
    {
        return __('subscription::resource.navigation.plans');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('subscription::resource.section.plan_details'))
                    ->schema([

                        TextInput::make('name')
                            ->label(__('subscription::resource.field.name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('price')
                            ->label(__('subscription::resource.field.price'))
                            ->required()
                            ->numeric()
                            ->prefix('EGP'),

                        TextInput::make('duration_days')
                            ->label(__('subscription::resource.field.duration_days'))
                            ->required()
                            ->numeric()
                            ->suffix('days'),

                        Toggle::make('is_active')
                            ->label(__('subscription::resource.field.is_active'))
                            ->default(true),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label(__('subscription::resource.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label(__('subscription::resource.field.price'))
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('duration_days')
                    ->label(__('subscription::resource.field.duration_days'))
                    ->suffix(' days')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('subscription::resource.field.is_active'))
                    ->boolean(),

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
            'index' => Pages\ListSubscriptionPlans::route('/'),
            'create' => Pages\CreateSubscriptionPlan::route('/create'),
            'edit' => Pages\EditSubscriptionPlan::route('/{record}/edit'),
        ];
    }
}