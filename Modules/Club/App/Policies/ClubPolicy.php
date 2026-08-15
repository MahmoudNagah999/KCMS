<?php

declare(strict_types=1);

namespace Modules\Club\App\Policies;

use App\Models\User;
use Modules\Shared\App\Support\Permissions\CrudPolicy;

class ClubPolicy extends CrudPolicy
{
    protected function resource(): string
    {
        return 'club';
    }

    /**
     * إنشاء نادي جديد (تسجيل tenant جديد) مختلف عن باقي عمليات الـ CRUD:
     * بيحصل *قبل* ما يبقى لليوزر أي نادي أو team context أصلاً، فمينفعش
     * نتأكد من صلاحية "create_club" العادية (اللي مرتبطة بـ team_id لنادي
     * معيّن) لأنها مش هتتحقق أبدًا لحد لسه مالوش نادي. أي مستخدم مسجّل
     * دخول يقدر يعمل أول نادي بتاعه.
     */
    public function create(User $user): bool
    {
        return true;
    }
}