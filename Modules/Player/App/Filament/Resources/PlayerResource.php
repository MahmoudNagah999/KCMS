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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Player Details')
                    ->schema([

                        FileUpload::make('photo')
                            ->image()
                            ->avatar()
                            ->directory('players'),

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('national_id')
                            ->label('National ID')
                            ->required()
                            ->length(14)
                            ->unique(ignoreRecord: true)->rule(fn () => fn (string $attribute, $value, \Closure $fail) => 
                                EgyptianNationalIdValidator::isValid($value) ?: $fail('الرقم القومي غير صحيح.')
                            )
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                if ($state && EgyptianNationalIdValidator::isValid($state)) {
                                    $set('gender', EgyptianNationalIdValidator::genderFrom($state)?->value);
                                    $set('birth_date', EgyptianNationalIdValidator::birthDateFrom($state)?->format('Y-m-d'));
                                }
                            }),

                        DatePicker::make('birth_date')
                            ->required()
                            ->maxDate(now()),

                        Select::make('gender')
                            ->options(
                                collect(Gender::cases())
                                    ->mapWithKeys(fn (Gender $g) => [$g->value => ucfirst($g->value)])
                                    ->toArray()
                            )
                            ->required(),

                        Select::make('belt')
                            ->options(
                                collect(BeltRank::cases())
                                    ->mapWithKeys(fn (BeltRank $b) => [$b->value => ucfirst($b->value)])
                                    ->toArray()
                            )
                            ->required()
                            ->searchable(),

                        TextInput::make('federation_number')
                            ->label('Federation Number')
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
                    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('national_id')
                    ->label('National ID')
                    ->searchable(),

                TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('gender')
                    ->badge(),

                TextColumn::make('belt')
                    ->badge()
                    ->sortable(),

                TextColumn::make('federation_number')
                    ->label('Federation #')
                    ->toggleable(),

            ])
            ->filters([

                SelectFilter::make('belt')
                    ->options(
                        collect(BeltRank::cases())
                            ->mapWithKeys(fn (BeltRank $b) => [$b->value => ucfirst($b->value)])
                            ->toArray()
                    ),

                SelectFilter::make('gender')
                    ->options(
                        collect(Gender::cases())
                            ->mapWithKeys(fn (Gender $g) => [$g->value => ucfirst($g->value)])
                            ->toArray()
                    ),

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

                Section::make('Player Details')
                    ->schema([

                        ImageEntry::make('photo')
                            ->circular(),

                        TextEntry::make('name'),

                        TextEntry::make('national_id')
                            ->label('National ID'),

                        TextEntry::make('birth_date')
                            ->date(),

                        TextEntry::make('gender')
                            ->badge(),

                        TextEntry::make('belt')
                            ->badge(),

                        TextEntry::make('federation_number')
                            ->label('Federation Number'),

                        TextEntry::make('created_at')
                            ->dateTime(),

                    ])
                    ->columns(2),

            ]);
    }
}