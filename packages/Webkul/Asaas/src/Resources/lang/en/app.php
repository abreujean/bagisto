<?php

return [
    'asaas' => [
        'title' => 'Asaas',
        'description' => 'Brazilian payment gateway with PIX, Boleto and Credit Card',

        'methods' => [
            'pix' => [
                'title' => 'Asaas PIX',
                'description' => 'Pay via PIX (instant payment)',
            ],
            'pix_copy_paste' => [
                'title' => 'PIX Copy and Paste',
                'description' => 'Use the PIX Copy and Paste code',
            ],
            'boleto' => [
                'title' => 'Asaas Boleto',
                'description' => 'Pay via Bank Slip',
            ],
            'card' => [
                'title' => 'Asaas Credit Card',
                'description' => 'Pay with Credit Card',
            ],
        ],

        'config' => [
            'api_key' => 'API Key',
            'api_key_info' => 'Asaas API Key (found in dashboard)',
            'environment' => 'Environment',
            'environment_info' => 'Select environment (Sandbox for testing)',
            'webhook_token' => 'Webhook Token',
            'webhook_token_info' => 'Token to validate webhooks received from Asaas',
        ],

        'messages' => [
            'payment_success' => 'Payment successful!',
            'payment_cancelled' => 'Payment cancelled',
            'payment_pending' => 'Payment pending',
            'webhook_received' => 'Webhook received successfully',
            'invalid_webhook_token' => 'Invalid webhook token',
        ],
    ],
];
