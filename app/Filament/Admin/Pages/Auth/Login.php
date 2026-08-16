<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    /**
     * نفس منطق الـ Login الأصلي بتاع Filament بالكامل،
     * بس بيغيّر الـ view بتاعته لواحد مقسوم نصين (فورم + معلومات عن المنصة).
     */
    protected string $view = 'filament.admin.pages.auth.login';
}