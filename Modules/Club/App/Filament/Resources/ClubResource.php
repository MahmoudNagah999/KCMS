<?php

declare(strict_types=1);

namespace Modules\Club\App\Filament\Resources;

use Filament\Tables;
use Filament\Schemas\Schema;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Modules\Club\App\Models\Club;
use Modules\Club\App\Filament\Resources\ClubResource\Pages;
use Modules\Shared\App\Enums\ClubStatus;
use Modules\Shared\App\Enums\SubscriptionStatus;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section;
use Modules\Club\App\Filament\Resources\ClubResource\RelationManagers;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    public static function getNavigationGroup(): ?string
    {
        return __('club::navigation.group');
    }

    protected static ?string $navigationLabel = null;

    public static function getNavigationLabel(): string
    {
        return __('club::navigation.clubs');
    }

    public static function getModelLabel(): string
    {
        return __('club::resource.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('club::resource.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('club::resource.section.club_information'))
                    ->schema([

                        Components\TextInput::make('code')
                            ->label(__('club::resource.field.code'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        Components\TextInput::make('name')
                            ->label(__('club::resource.field.name'))
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('name_en')
                            ->label(__('club::resource.field.name_en'))
                            ->maxLength(255),

                        Components\TextInput::make('email')
                            ->label(__('club::resource.field.email'))
                            ->email()
                            ->maxLength(255),

                        Components\TextInput::make('phone')
                            ->label(__('club::resource.field.phone'))
                            ->tel()
                            ->maxLength(30),

                        Components\FileUpload::make('logo')
                            ->label(__('club::resource.field.logo'))
                            ->image()
                            ->directory('clubs/logos'),

                        Components\Textarea::make('address')
                            ->label(__('club::resource.field.address'))
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make(__('club::resource.section.status'))
                    ->schema([

                        Components\Select::make('club_status')
                            ->label(__('club::resource.field.club_status'))
                            ->options(ClubStatus::class)
                            ->default(ClubStatus::ACTIVE->value)
                            ->required(),

                        Components\Select::make('subscription_status')
                            ->label(__('club::resource.field.subscription_status'))
                            ->options(SubscriptionStatus::class)
                            ->default(SubscriptionStatus::TRIAL->value)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('code')
                    ->label(__('club::resource.field.code'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('club::resource.field.name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('club::resource.field.phone')),

                Tables\Columns\TextColumn::make('club_status')
                    ->label(__('club::resource.field.club_status'))
                    ->badge()
                    ->color(fn (ClubStatus $state): string => match ($state) {
                        ClubStatus::ACTIVE => 'success',
                        ClubStatus::SUSPENDED => 'danger',
                        ClubStatus::INACTIVE => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('subscription_status')
                    ->label(__('club::resource.field.subscription_status'))
                    ->badge()
                    ->color(fn (SubscriptionStatus $state): string => match ($state) {
                        SubscriptionStatus::ACTIVE => 'success',
                        SubscriptionStatus::TRIAL => 'warning',
                        SubscriptionStatus::EXPIRED,
                        SubscriptionStatus::CANCELLED => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('club::resource.field.created_at'))
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([

                Tables\Filters\SelectFilter::make('club_status')
                    ->label(__('club::resource.field.club_status'))
                    ->options(ClubStatus::class),

                Tables\Filters\SelectFilter::make('subscription_status')
                    ->label(__('club::resource.field.subscription_status'))
                    ->options(SubscriptionStatus::class),

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
            'index' => Pages\ListClubs::route('/'),
            'create' => Pages\CreateClub::route('/create'),
            'edit' => Pages\EditClub::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
            RelationManagers\SubscriptionsRelationManager::class,
        ];
    }
}