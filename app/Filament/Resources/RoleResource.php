<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    public static function getNavigationGroup(): ?string
    {
        return __('app::resource.navigation.access_control');
    }

    public static function getModelLabel(): string
    {
        return __('app::resource.role.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app::resource.role.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('app::resource.role.section.details'))
                    ->schema([

                        TextInput::make('name')
                            ->label(__('app::resource.role.field.name'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Hidden::make('guard_name')
                            ->default('web'),

                    ]),

                Section::make(__('app::resource.role.section.permissions'))
                    ->schema([

                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'name')
                            ->searchable()
                            ->bulkToggleable()
                            ->columns(2),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label(__('app::resource.role.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label(__('app::resource.role.field.permissions_count'))
                    ->badge(),

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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}