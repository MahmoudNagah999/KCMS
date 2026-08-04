<?php

declare(strict_types=1);

namespace Modules\Club\App\DTOs;

use Modules\Shared\App\Enums\ClubStatus;
use Modules\Shared\App\Enums\SubscriptionStatus;

final class CreateClubData
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly ?string $nameEn,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $logo,
        public readonly ?string $address,
        public readonly ClubStatus $clubStatus,
        public readonly SubscriptionStatus $subscriptionStatus,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
            name: $data['name'],
            nameEn: $data['name_en'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            logo: $data['logo'] ?? null,
            address: $data['address'] ?? null,
            clubStatus: ClubStatus::from($data['club_status'] ?? ClubStatus::ACTIVE->value),
            subscriptionStatus: SubscriptionStatus::from($data['subscription_status'] ?? SubscriptionStatus::TRIAL->value),
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'name_en' => $this->nameEn,
            'email' => $this->email,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'address' => $this->address,
            'club_status' => $this->clubStatus,
            'subscription_status' => $this->subscriptionStatus,
        ];
    }
}