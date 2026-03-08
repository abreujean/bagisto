<?php

return [
    'asaas' => [
        'title' => 'Asaas',
        'description' => 'Gateway de pagamento Asaas',

        'methods' => [
            'pix' => [
                'title' => 'PIX Asaas',
                'description' => 'Pague via PIX (pagamento instantâneo)',
            ],
            'pix_copy_paste' => [
                'title' => 'PIX Copia e Cola',
                'description' => 'Use o código PIX Copia e Cola',
            ],
            'boleto' => [
                'title' => 'Boleto Asaas',
                'description' => 'Pague via Boleto Bancário',
            ],
            'card' => [
                'title' => 'Cartão de Crédito Asaas',
                'description' => 'Pague com Cartão de Crédito',
            ],
        ],

        'config' => [
            'api_key' => 'API Key',
            'api_key_info' => 'Chave de API do Asaas (encontrada no painel)',
            'environment' => 'Ambiente',
            'environment_info' => 'Selecione o ambiente (Sandbox para testes)',
            'webhook_token' => 'Token do Webhook',
            'webhook_token_info' => 'Token para validar webhooks recebidos do Asaas',
        ],

        'messages' => [
            'payment_success' => 'Pagamento realizado com sucesso!',
            'payment_cancelled' => 'Pagamento cancelado',
            'payment_pending' => 'Pagamento pendente',
            'webhook_received' => 'Webhook recebido com sucesso',
            'invalid_webhook_token' => 'Token do webhook inválido',
        ],
    ],
];
