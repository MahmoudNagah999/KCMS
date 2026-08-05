<?php

declare(strict_types=1);

namespace Modules\Club\App\Filament\Resources\ClubResource\RelationManagers;

use App\Models\User;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Shared\App\Enums\ClubRole;
use Spatie\Permission\PermissionRegistrar;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function mount(): void
    {
        parent::mount();

        // مهم: الـ Admin panel مش tenant-aware زي الـ Club panel،
        // فمحتاجين نظبط الـ team context يدوي هنا
        app(PermissionRegistrar::class)
            ->setPermissionsTeamId($this->getOwnerRecord()->getKey());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('role')
                    ->label('Role')
                    ->options(
                        collect(ClubRole::cases())
                            ->mapWithKeys(fn (ClubRole $role) => [
                                $role->value => ucfirst($role->value),
                            ])
                            ->toArray()
                    )
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->state(fn (User $record): string => $record->roles->pluck('name')->join(', ') ?: '—'),

            ])
            ->headerActions([

                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('role')
                            ->label('Role')
                            ->options(
                                collect(ClubRole::cases())
                                    ->mapWithKeys(fn (ClubRole $role) => [
                                        $role->value => ucfirst($role->value),
                                    ])
                                    ->toArray()
                            )
                            ->required(),
                    ])
                    ->after(function (array $data, User $record): void {
                        $record->syncRoles([$data['role']]);
                    }),

            ])
            ->recordActions([

                EditAction::make()
                    ->fillForm(fn (User $record): array => [
                        'role' => $record->roles->first()?->name,
                    ])
                    ->action(function (array $data, User $record): void {
                        $record->syncRoles([$data['role']]);
                    }),

                DetachAction::make(),

            ])
            ->toolbarActions([
                DetachBulkAction::make(),
            ]);
    }
}