<?php
return [
    'timeout' => 2.0,
    'crm'=>[
        'default' => 'default',
        'url' => env('UDESK_CRM_URL', ''),
        'apps'=>[
            'default' => [
                'email' => env('UDESK_CRM_EMAIL', ''),
                'secret_key' => env('UDESK_CRM_SECRET_KEY', ''),
            ]
        ],
    ],
    'ccps'=>[
        'default' => 'default',
        'url' => env('UDESK_CCPS_URL', ''),
        'apps'=>[
            'default' => [
                'email' => env('UDESK_CCPS_EMAIL', ''),
                'appId'=>env('UDESK_CCPS_APPID', ''),
                'secret' => env('UDESK_CCPS_SECRET_KEY', ''),
            ]
        ],
    ],
    'http' => [
        'options' => [],
    ],
];
