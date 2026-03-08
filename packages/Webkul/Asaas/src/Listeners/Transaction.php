<?php

namespace Webkul\Asaas\Listeners;

use Webkul\Sales\Repositories\OrderTransactionRepository;

class Transaction
{
    protected $orderTransactionRepository;

    public function __construct(OrderTransactionRepository $orderTransactionRepository)
    {
        $this->orderTransactionRepository = $orderTransactionRepository;
    }

    public function saveTransaction($invoice)
    {
        $paymentId = session()->get('asaas_payment_id');

        if (! $paymentId) {
            return;
        }

        $order = $invoice->order;

        if (! in_array($order->payment->method, ['asaas_pix', 'asaas_pix_copy_paste', 'asaas_boleto'])) {
            return;
        }

        $paymentClass = $order->payment->method === 'asaas_boleto'
            ? 'Webkul\Asaas\Payment\Boleto'
            : 'Webkul\Asaas\Payment\Pix';

        $payment = new $paymentClass;
        $data = $payment->getPayment($paymentId);

        if (! $data) {
            return;
        }

        $this->orderTransactionRepository->create([
            'transaction_id' => $data['id'],
            'status' => $data['status'],
            'type' => $data['billingType'],
            'amount' => $data['value'],
            'payment_method' => $order->payment->method,
            'order_id' => $order->id,
            'invoice_id' => $invoice->id,
            'data' => json_encode($data),
        ]);
    }
}
