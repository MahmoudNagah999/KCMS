<?php

declare(strict_types=1);

namespace App\Filament\Club\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Club\App\Actions\CreateClubAction;
use Modules\Club\App\DTOs\CreateClubData;
use Modules\Club\App\Models\Club;
use Modules\Shared\App\Enums\ClubRole;
use Modules\Shared\App\Enums\ClubStatus;
use Modules\Shared\App\Enums\SubscriptionStatus;
use Modules\Subscription\App\Models\Subscription;
use Modules\Subscription\App\Models\SubscriptionPlan;
use Spatie\Permission\PermissionRegistrar;

class RegisterClub extends RegisterTenant
{
    private const TRIAL_DURATION_DAYS = 7;

    protected string $view = 'filament.club.pages.tenancy.register-club';

    public static function getLabel(): string
    {
        return __('register-club.form.submit');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label(__('register-club.form.name_label'))
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label(__('register-club.form.email_label'))
                    ->email()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label(__('register-club.form.phone_label'))
                    ->tel()
                    ->maxLength(30),

            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        return DB::transaction(function () use ($data): Club {

            $club = app(CreateClubAction::class)->execute(
                CreateClubData::fromArray([
                    'code' => $this->generateUniqueClubCode($data['name']),
                    'name' => $data['name'],
                    'email' => $data['email'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'club_status' => ClubStatus::ACTIVE->value,
                    'subscription_status' => SubscriptionStatus::TRIAL->value,
                ])
            );

            $user = auth()->user();

            $club->users()->attach($user->id);

            // لازم نحدد الـ team الحالي قبل ما نـ assign role،
            // لأن الـ roles هنا مربوطة بالنادي عن طريق spatie/laravel-permission teams
            app(PermissionRegistrar::class)->setPermissionsTeamId($club->id);

            $user->assignRole(ClubRole::OWNER->value);

            $trialPlan = SubscriptionPlan::query()->firstOrCreate(
                ['name' => 'Free Trial'],
                [
                    'price' => 0,
                    'duration_days' => self::TRIAL_DURATION_DAYS,
                    'is_active' => true,
                ],
            );

            Subscription::create([
                'club_id' => $club->id,
                'subscription_plan_id' => $trialPlan->id,
                'price_paid' => 0,
                'starts_at' => now(),
                'ends_at' => now()->addDays(self::TRIAL_DURATION_DAYS),
                'status' => SubscriptionStatus::TRIAL->value,
            ]);

            return $club;
        });
    }

    private function generateUniqueClubCode(string $name): string
    {
        $base = strtoupper(Str::slug($name, ''));
        $base = $base !== '' ? substr($base, 0, 10) : 'CLUB';

        $code = $base;
        $suffix = 1;

        while (Club::query()->where('code', $code)->exists()) {
            $code = $base.$suffix;
            $suffix++;
        }

        return $code;
    }
}