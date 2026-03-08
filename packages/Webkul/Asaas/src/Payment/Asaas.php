<?php

namespace Webkul\Asaas\Payment;

use Webkul\Asaas\Helpers\AsaasHttpClient;
use Webkul\Payment\Payment\Payment;

abstract class Asaas extends Payment
{
    protected $billingType;

    protected $cart;

    protected $asaasClient;

    public function __construct()
    {
        $this->asaasClient = new AsaasHttpClient;
        parent::__construct();
    }

    public function isAvailable(): bool
    {
        return $this->getConfigData('active') && $this->getConfigData('api_key');
    }

    public function getConfigData($field)
    {
        return core()->getConfigData('sales.payment_methods.'.$this->getCode().'.'.$field);
    }

    protected function createCustomer($cart)
    {
        $address = $cart->shipping_address;
        $customer = $cart->customer;

        $customerData = [
            'name' => $address->first_name.' '.$address->last_name,
            'email' => $address->email,
            'phone' => $this->formatPhone($address->phone),
            'cpfCnpj' => $customer->cpf_cnpj ?? '00000000000',
            'notificationDisabled' => false,
        ];

        $response = $this->asaasClient->post('customers', $customerData);

        return $response['id'] ?? null;
    }

    protected function createPayment($cart, $customerId, $billingType)
    {
        $paymentData = [
            'customer' => $customerId,
            'billingType' => $billingType,
            'value' => (float) $cart->grand_total,
            'dueDate' => now()->addDays(3)->format('Y-m-d'),
            'description' => "Pedido #{$cart->id}",
            'externalReference' => (string) $cart->id,
            'postalService' => false,
        ];

        $response = $this->asaasClient->post('payments', $paymentData);

        return $response;
    }

    protected function getPayment($paymentId)
    {
        return $this->asaasClient->get("payments/{$paymentId}");
    }

    protected function formatPhone($phone)
    {
        return preg_replace('/\D/', '', $phone);
    }

    protected function getEnvironment(): string
    {
        return $this->getConfigData('environment') ?: 'sandbox';
    }

    public function getWebhookToken(): string
    {
        return $this->getConfigData('webhook_token') ?? '';
    }
}
