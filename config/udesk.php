<?php
return [
    'timeout' => 2.0,
    'crm'=>[
        'url' => env('UDESK_CRM_URL', ''),
        'apps'=>[
            'default' => [
                'email' => env('UDESK_CRM_EMAIL', ''),
                'secret_key' => env('UDESK_CRM_SECRET_KEY', ''),
            ]
        ],
    ],
    'http' => [
        'options' => [],
    ],
];
