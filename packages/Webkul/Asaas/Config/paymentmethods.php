<?php

return [
    'asaas_pix' => [
        'code' => 'asaas_pix',
        'title' => 'PIX Asaas',
        'description' => 'Pague via PIX',
        'class' => 'Webkul\Asaas\Payment\Pix',
        'active' => true,
        'sort' => 10,
        'billing_type' => 'PIX',
    ],
    'asaas_pix_copy_paste' => [
        'code' => 'asaas_pix_copy_paste',
        'title' => 'PIX Copia e Cola',
        'description' => 'PIX Copia e Cola',
        'class' => 'Webkul\Asaas\Payment\PixCopyPaste',
        'active' => true,
        'sort' => 11,
        'billing_type' => 'PIX',
    ],
    'asaas_boleto' => [
        'code' => 'asaas_boleto',
        'title' => 'Boleto Asaas',
        'description' => 'Pague via Boleto Bancário',
        'class' => 'Webkul\Asaas\Payment\Boleto',
        'active' => true,
        'sort' => 12,
        'billing_type' => 'BOLETO',
    ],
    'asaas_card' => [
        'code' => 'asaas_card',
        'title' => 'Cartão de Crédito Asaas',
        'description' => 'Pague com Cartão de Crédito',
        'class' => 'Webkul\Asaas\Payment\Card',
        'active' => true,
        'sort' => 13,
        'billing_type' => 'CREDIT_CARD',
    ],
];
