<?php

namespace Webkul\Asaas\Payment;

class Boleto extends Asaas
{
    protected $code = 'asaas_boleto';

    public function getRedirectUrl()
    {
        return route('asaas.boleto.redirect');
    }

    public function getBoletoUrl($paymentId): ?string
    {
        $payment = $this->getPayment($paymentId);

        return $payment['invoiceUrl'] ?? null;
    }

    public function getBoletoData($paymentId): ?array
    {
        $payment = $this->getPayment($paymentId);

        return [
            'invoiceUrl' => $payment['invoiceUrl'] ?? null,
            'dueDate' => $payment['dueDate'] ?? null,
            'status' => $payment['status'] ?? null,
            'bankSlipUrl' => $payment['bankSlipUrl'] ?? null,
        ];
    }
}
