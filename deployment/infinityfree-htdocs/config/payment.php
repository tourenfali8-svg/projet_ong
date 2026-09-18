<?php
/**
 * Configuration des opérateurs de paiement (Mobile Money & Wave)
 */

return [
    'mode' => $_ENV['PAYMENT_MODE'] ?? 'simulation', // 'simulation' ou 'live'

    'operators' => [
        'wave' => [
            'name' => 'Wave',
            'code' => 'wave',
            'icon' => 'wave-icon.svg',
            'color' => '#1dc3f1',
            'enabled' => true,
            'number' => '+225 07 07 07 80 29',
            'api_key' => $_ENV['WAVE_API_KEY'] ?? ''
        ],
        'orange_money' => [
            'name' => 'Orange Money',
            'code' => 'orange_money',
            'icon' => 'orange-icon.svg',
            'color' => '#ff7900',
            'enabled' => true,
            'number' => '+225 07 07 07 80 29',
            'client_id' => $_ENV['ORANGE_MONEY_CLIENT_ID'] ?? '',
            'client_secret' => $_ENV['ORANGE_MONEY_CLIENT_SECRET'] ?? ''
        ],
        'mtn_money' => [
            'name' => 'MTN Mobile Money',
            'code' => 'mtn_money',
            'icon' => 'mtn-icon.svg',
            'color' => '#ffcc00',
            'enabled' => true,
            'number' => '+225 07 07 07 80 29',
            'primary_key' => $_ENV['MTN_MOMO_PRIMARY_KEY'] ?? ''
        ],
        'moov_money' => [
            'name' => 'Moov Money',
            'code' => 'moov_money',
            'icon' => 'moov-icon.svg',
            'color' => '#005baa',
            'enabled' => true,
            'number' => '+225 07 07 07 80 29',
            'api_key' => $_ENV['MOOV_MONEY_API_KEY'] ?? ''
        ]
    ]
];
