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

    protected static ?string $modelLabel = 'Club';

    protected static ?string $pluralModelLabel = 'Clubs';

    public static function form(Schema $schema): Schema 
    {
        return $schema
            ->components([

                Section::make('Club Information')
                    ->schema([

                        Components\TextInput::make('code')
                            ->label('Club Code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        Components\TextInput::make('name')
                            ->label('Arabic Name')
                            ->required()
                            ->maxLength(255),

                        Components\TextInput::make('name_en')
                            ->label('English Name')
                            ->maxLength(255),

                        Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),

                        Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(30),

                        Components\FileUpload::make('logo')
                            ->image()
                            ->directory('clubs/logos'),

                        Components\Textarea::make('address')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Status')
                    ->schema([

                        Components\Select::make('club_status')
                            ->label('Club Status')
                            ->options(
                                collect(ClubStatus::cases())
                                    ->mapWithKeys(fn (ClubStatus $status) => [
                                        $status->value => ucfirst($status->value),
                                    ])
                                    ->toArray()
                            )
                            ->default(ClubStatus::ACTIVE->value)
                            ->required(),

                        Components\Select::make('subscription_status')
                            ->label('Subscription Status')
                            ->options(
                                collect(SubscriptionStatus::cases())
                                    ->mapWithKeys(fn (SubscriptionStatus $status) => [
                                        $status->value => ucfirst($status->value),
                                    ])
                                    ->toArray()
                            )
                            ->default(SubscriptionStatus::TRIAL->value)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }


    public static function table(
        Tables\Table $table
    ): Tables\Table {

        return $table
            ->columns([

                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone'),

                Tables\Columns\TextColumn::make('club_status')
                    ->badge()
                    ->color(fn (ClubStatus  $state): string => match ($state) {

                        ClubStatus::ACTIVE => 'success',

                        ClubStatus::SUSPENDED => 'danger',

                        ClubStatus::INACTIVE => 'gray',

                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('subscription_status')
                    ->badge()
                    ->color(fn (SubscriptionStatus $state): string => match ($state) {

                        SubscriptionStatus::ACTIVE => 'success',

                        SubscriptionStatus::TRIAL => 'warning',

                        SubscriptionStatus::EXPIRED,
                        SubscriptionStatus::CANCELLED => 'danger',

                        default => 'gray',
                    }),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('club_status')
                    ->options(
                        collect(ClubStatus::cases())
                            ->mapWithKeys(fn (ClubStatus $status) => [
                                $status->value => ucfirst($status->value),
                            ])
                            ->toArray()
                    ),


                Tables\Filters\SelectFilter::make('subscription_status')
                    ->options(
                        collect(SubscriptionStatus::cases())
                            ->mapWithKeys(fn (SubscriptionStatus $status) => [
                                $status->value => ucfirst($status->value),
                            ])
                            ->toArray()
                    ),

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
}