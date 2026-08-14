<?php

declare(strict_types=1);

namespace Modules\Player\App\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Player\App\Filament\Resources\PlayerResource\Pages;
use Modules\Player\App\Models\Player;
use Modules\PlayerSubscription\App\Filament\RelationManagers\PlayerSubscriptionsRelationManager;
use Modules\Shared\App\Enums\BeltRank;
use Modules\Shared\App\Enums\Gender;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Player\App\Support\EgyptianNationalIdValidator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    public static function getModelLabel(): string
    {
        return __('player::resource.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('player::resource.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('player::resource.section.player_details'))
                    ->schema([

                        FileUpload::make('photo')
                            ->label(__('player::resource.field.photo'))
                            ->image()
                            ->avatar()
                            ->directory('players'),

                        TextInput::make('name')
                            ->label(__('player::resource.field.name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('national_id')
                            ->label(__('player::resource.field.national_id'))
                            ->required()
                            ->length(14)
                            ->unique(ignoreRecord: true)->rule(fn () => fn (string $attribute, $value, \Closure $fail) =>
                                EgyptianNationalIdValidator::isValid($value) ?: $fail(__('player::resource.validation.invalid_national_id'))
                            )
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                if ($state && EgyptianNationalIdValidator::isValid($state)) {
                                    $set('gender', EgyptianNationalIdValidator::genderFrom($state)?->value);
                                    $set('birth_date', EgyptianNationalIdValidator::birthDateFrom($state)?->format('Y-m-d'));
                                }
                            }),

                        DatePicker::make('birth_date')
                            ->label(__('player::resource.field.birth_date'))
                            ->required()
                            ->maxDate(now()),

                        Select::make('gender')
                            ->label(__('player::resource.field.gender'))
                            ->options(Gender::class)
                            ->required(),

                        Select::make('belt')
                            ->label(__('player::resource.field.belt'))
                            ->options(BeltRank::class)
                            ->required()
                            ->searchable(),

                        TextInput::make('federation_number')
                            ->label(__('player::resource.field.federation_number'))
                            ->unique(ignoreRecord: true),

                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('photo')
                    ->label(__('player::resource.field.photo'))
                    ->circular(),

                TextColumn::make('name')
                    ->label(__('player::resource.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('national_id')
                    ->label(__('player::resource.field.national_id'))
                    ->searchable(),

                TextColumn::make('birth_date')
                    ->label(__('player::resource.field.birth_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('gender')
                    ->label(__('player::resource.field.gender'))
                    ->badge(),

                TextColumn::make('belt')
                    ->label(__('player::resource.field.belt'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('federation_number')
                    ->label(__('player::resource.field.federation_number_short'))
                    ->toggleable(),

            ])
            ->filters([

                SelectFilter::make('belt')
                    ->label(__('player::resource.field.belt'))
                    ->options(BeltRank::class),

                SelectFilter::make('gender')
                    ->label(__('player::resource.field.gender'))
                    ->options(Gender::class),

                TrashedFilter::make(),

            ])
            ->recordActions([

                ViewAction::make(),
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
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'view' => Pages\ViewPlayer::route('/{record}'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('player::resource.section.player_details'))
                    ->schema([

                        ImageEntry::make('photo')
                            ->label(__('player::resource.field.photo'))
                            ->circular(),

                        TextEntry::make('name')
                            ->label(__('player::resource.field.name')),

                        TextEntry::make('national_id')
                            ->label(__('player::resource.field.national_id')),

                        TextEntry::make('birth_date')
                            ->label(__('player::resource.field.birth_date'))
                            ->date(),

                        TextEntry::make('gender')
                            ->label(__('player::resource.field.gender'))
                            ->badge(),

                        TextEntry::make('belt')
                            ->label(__('player::resource.field.belt'))
                            ->badge(),

                        TextEntry::make('federation_number')
                            ->label(__('player::resource.field.federation_number')),

                        TextEntry::make('created_at')
                            ->label(__('player::resource.field.created_at'))
                            ->dateTime(),

                    ])
                    ->columns(2),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            PlayerSubscriptionsRelationManager::class,
        ];
    }
}