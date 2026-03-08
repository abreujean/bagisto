<?php

namespace Webkul\Asaas\Helpers;

class WebhookHelper
{
    public function handlePaymentConfirmed($paymentData): void
    {
        $orderId = $paymentData['externalReference'] ?? null;

        if ($orderId) {
            AsaasHelper::updateOrderStatus($orderId, 'CONFIRMED');
        }
    }

    public function handlePaymentReceived($paymentData): void
    {
        $orderId = $paymentData['externalReference'] ?? null;

        if ($orderId) {
            AsaasHelper::updateOrderStatus($orderId, 'RECEIVED');
        }
    }

    public function handlePaymentRefunded($paymentData): void
    {
        $orderId = $paymentData['externalReference'] ?? null;

        if ($orderId) {
            AsaasHelper::updateOrderStatus($orderId, 'REFUNDED');
        }
    }

    public function handlePaymentDeleted($paymentData): void
    {
        $orderId = $paymentData['externalReference'] ?? null;

        if ($orderId) {
            AsaasHelper::updateOrderStatus($orderId, 'CANCELLED');
        }
    }
}
