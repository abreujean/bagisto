<?php

namespace Webkul\Asaas\Payment;

class Pix extends Asaas
{
    protected $code = 'asaas_pix';

    public function getRedirectUrl()
    {
        return route('asaas.pix.redirect');
    }

    public function getQrCodeData($paymentId): ?array
    {
        $payment = $this->getPayment($paymentId);

        return [
            'encodedImage' => $payment['encodedImage'] ?? null,
            'payload' => $payment['payload'] ?? null,
            'invoiceUrl' => $payment['invoiceUrl'] ?? null,
            'status' => $payment['status'] ?? null,
        ];
    }
}
