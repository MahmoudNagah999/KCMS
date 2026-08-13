<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

   public static function getModelLabel(): string
    {
        return __('app::resource.user.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app::resource.user.model.plural');
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('app::resource.user.section.details'))
                    ->schema([

                        TextInput::make('name')
                            ->label(__('app::resource.user.field.name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label(__('app::resource.user.field.email'))
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label(__('app::resource.user.field.password'))
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label(__('app::resource.user.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('app::resource.user.field.email'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('app::resource.user.field.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}