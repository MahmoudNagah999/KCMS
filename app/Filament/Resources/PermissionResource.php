<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-key';

    public static function getNavigationGroup(): ?string
    {
        return __('app::resource.navigation.access_control');
    }

    public static function getModelLabel(): string
    {
        return __('app::resource.permission.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app::resource.permission.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label(__('app::resource.permission.field.name'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText(__('app::resource.permission.help.name')),

                Hidden::make('guard_name')->default('web'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label(__('app::resource.permission.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('guard_name')
                    ->label(__('app::resource.permission.field.guard_name'))
                    ->badge(),

            ]);
            // مفيش recordActions ولا toolbarActions خالص — الـ Resource ده read-only بالتصميم
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
        ];
    }
}