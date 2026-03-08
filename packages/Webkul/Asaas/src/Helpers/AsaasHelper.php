<?php

namespace Webkul\Asaas\Helpers;

class AsaasHelper
{
    public static function mapStatus($asaasStatus): string
    {
        $statusMap = [
            'PENDING' => 'pending',
            'CONFIRMED' => 'processing',
            'RECEIVED' => 'completed',
            'REFUNDED' => 'refunded',
            'CANCELLED' => 'canceled',
            'OVERDUE' => 'pending',
        ];

        return $statusMap[$asaasStatus] ?? 'pending';
    }

    public static function updateOrderStatus($orderId, $asaasStatus): void
    {
        $status = self::mapStatus($asaasStatus);

        app('Webkul\Sales\Repositories\OrderRepository')->update([
            'status' => $status,
        ], $orderId);
    }
}
