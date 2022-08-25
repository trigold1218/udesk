<?php
return [
    'timeout' => 2.0,
    'apps' => [
        'crm' => [
            'default' => [
                'url' => env('UDESK_CRM_URL', ''),
                'email' => env('UDESK_CRM_EMAIL', ''),
                'secret_key' => env('UDESK_CRM_SECRET_KEY', ''),
            ],
        ],
    ],
];
