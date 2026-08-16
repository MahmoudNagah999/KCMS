<?php

return [

    'admin' => [
        'stat' => [
            'total_clubs' => 'Total Clubs',
            'active_clubs' => 'Active Clubs',
            'active_subscriptions' => 'Active Subscriptions',
            'trial_clubs' => 'Trial Clubs',
            'active_subscriptions_revenue' => 'Active Subscriptions Revenue',
        ],
        'expiring_subscriptions' => [
            'heading' => 'Subscriptions Expiring Within 7 Days',
            'column' => [
                'club' => 'Club',
                'plan' => 'Plan',
                'ends_at' => 'Expires On',
            ],
        ],
    ],

    'club' => [
        'stat' => [
            'total_players' => 'Total Players',
            'active_subscriptions' => 'Active Subscriptions',
            'expiring_soon' => 'Expiring Within 7 Days',
            'monthly_revenue' => 'This Month\'s Revenue',
        ],
        'expiring_subscriptions' => [
            'heading' => 'Player Subscriptions Expiring Within 7 Days',
            'empty_state' => 'No subscriptions expiring soon',
            'column' => [
                'player' => 'Player',
                'plan' => 'Plan',
                'ends_at' => 'Expires On',
            ],
        ],
    ],

];