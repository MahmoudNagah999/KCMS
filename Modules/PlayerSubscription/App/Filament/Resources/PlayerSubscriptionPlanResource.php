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

    protected static string|\UnitEnum|null $navigationGroup = 'Subscriptions';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Plan Details')
                    ->schema([

                        TextInput::make('name')
                            ->label('اسم الباقة')
                            ->required()
                            ->maxLength(255),

                        Select::make('billing_type')
                            ->label('نوع الاحتساب')
                            ->options(
                                collect(PlanBillingType::cases())
                                    ->mapWithKeys(fn (PlanBillingType $type) => [
                                        $type->value => match ($type) {
                                            PlanBillingType::DURATION => 'مدة (شهري / نص شهري ...)',
                                            PlanBillingType::SESSIONS => 'عدد حصص',
                                        },
                                    ])
                                    ->toArray()
                            )
                            ->required()
                            ->live()
                            ->native(false),

                        TextInput::make('price')
                            ->label('السعر')
                            ->numeric()
                            ->prefix('EGP')
                            ->required(),

                        TextInput::make('duration_days')
                            ->label('المدة (بالأيام)')
                            ->numeric()
                            ->required()
                            ->visible(fn (Get $get): bool => $get('billing_type') === PlanBillingType::DURATION->value),

                        TextInput::make('sessions_count')
                            ->label('عدد الحصص')
                            ->numeric()
                            ->required()
                            ->visible(fn (Get $get): bool => $get('billing_type') === PlanBillingType::SESSIONS->value),

                        Toggle::make('is_active')
                            ->label('مفعّلة')
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
                    ->label('اسم الباقة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('billing_type')
                    ->label('النوع')
                    ->badge(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('duration_days')
                    ->label('المدة (يوم)')
                    ->placeholder('—'),

                TextColumn::make('sessions_count')
                    ->label('عدد الحصص')
                    ->placeholder('—'),

                IconColumn::make('is_active')
                    ->label('مفعّلة')
                    ->boolean(),

            ])
            ->filters([

                SelectFilter::make('billing_type')
                    ->options(
                        collect(PlanBillingType::cases())
                            ->mapWithKeys(fn (PlanBillingType $type) => [$type->value => $type->value])
                            ->toArray()
                    ),

                TernaryFilter::make('is_active')
                    ->label('الحالة'),

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