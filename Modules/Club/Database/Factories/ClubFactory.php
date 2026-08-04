<?php

declare(strict_types=1);

namespace Modules\Club\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Club\App\Models\Club;
use Modules\Shared\App\Enums\ClubStatus;
use Modules\Shared\App\Enums\SubscriptionStatus;

class ClubFactory extends Factory
{
    protected $model = Club::class;


    public function definition(): array
    {
        return [

            'code' => fake()
                ->unique()
                ->bothify('CLUB-####'),

            'name' => fake()
                ->company(),

            'name_en' => fake()
                ->company(),

            'email' => fake()
                ->safeEmail(),

            'phone' => fake()
                ->phoneNumber(),

            'address' => fake()
                ->address(),

            'club_status' => ClubStatus::ACTIVE,

            'subscription_status' => SubscriptionStatus::TRIAL,

        ];
    }

    public function suspended(): static
    {
        return $this->state(fn () => [

            'club_status' => ClubStatus::SUSPENDED,

            'subscription_status' => SubscriptionStatus::EXPIRED,

        ]);
    }


    public function active(): static
    {
        return $this->state(fn () => [

            'club_status' => ClubStatus::ACTIVE,

            'subscription_status' => SubscriptionStatus::ACTIVE,

        ]);
    }
}