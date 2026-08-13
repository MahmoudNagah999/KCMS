<?php

return [

    'navigation' => [
        'access_control' => 'إدارة الصلاحيات',
    ],

    'user' => [
        'model' => [
            'singular' => 'مستخدم',
            'plural' => 'المستخدمين',
        ],
        'section' => [
            'details' => 'بيانات المستخدم',
        ],
        'field' => [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
            'created_at' => 'تاريخ الإضافة',
        ],
    ],

    'role' => [
        'model' => [
            'singular' => 'دور',
            'plural' => 'الأدوار',
        ],
        'section' => [
            'details' => 'بيانات الدور',
            'permissions' => 'الصلاحيات',
        ],
        'field' => [
            'name' => 'الاسم',
            'permissions_count' => 'عدد الصلاحيات',
        ],
    ],

    'permission' => [
        'model' => [
            'singular' => 'صلاحية',
            'plural' => 'الصلاحيات',
        ],
        'field' => [
            'name' => 'الاسم',
            'guard_name' => 'الـ Guard',
        ],
        'help' => [
            'name' => 'مثال: view_players, create_players, manage_subscriptions',
        ],
    ],

];