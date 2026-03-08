<?php

namespace Webkul\Asaas\Payment;

class PixCopyPaste extends Asaas
{
    protected $code = 'asaas_pix_copy_paste';

    public function getRedirectUrl()
    {
        return route('asaas.pix-copy-paste.redirect');
    }

    public function getCopyPasteCode($paymentId): ?string
    {
        $payment = $this->getPayment($paymentId);

        return $payment['payload'] ?? null;
    }
}
