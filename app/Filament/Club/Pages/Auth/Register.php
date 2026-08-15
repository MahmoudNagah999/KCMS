<?php

declare(strict_types=1);

namespace App\Filament\Club\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;

class Register extends BaseRegister
{
    /**
     * بيعمل بس User جديد (اسم/إيميل/باسورد).
     * بعدها فيلامنت هيلاقي المستخدم مالوش نادي، فهيوجهه تلقائي
     * لصفحة RegisterClub (Tenant Registration) اللي بتعمل النادي
     * وتدي الـ owner role — يعني نفس اللي إنت عايزه بالظبط.
     */
    protected string $view = 'filament.club.pages.auth.register';
}