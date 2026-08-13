<?php

return [

    'navigation' => [
        'access_control' => 'Access Control',
    ],

    'user' => [
        'model' => [
            'singular' => 'User',
            'plural' => 'Users',
        ],
        'section' => [
            'details' => 'User Details',
        ],
        'field' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'created_at' => 'Created At',
        ],
    ],

    'role' => [
        'model' => [
            'singular' => 'Role',
            'plural' => 'Roles',
        ],
        'section' => [
            'details' => 'Role Details',
            'permissions' => 'Permissions',
        ],
        'field' => [
            'name' => 'Name',
            'permissions_count' => 'Permissions',
        ],
    ],

    'permission' => [
        'model' => [
            'singular' => 'Permission',
            'plural' => 'Permissions',
        ],
        'field' => [
            'name' => 'Name',
            'guard_name' => 'Guard',
        ],
        'help' => [
            'name' => 'e.g. view_players, create_players, manage_subscriptions',
        ],
    ],

];