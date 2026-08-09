<?php

declare(strict_types=1);

namespace Modules\Player\App\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                            ->unique(ignoreRecord: true),

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
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }
}