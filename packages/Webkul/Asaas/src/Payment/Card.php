<?php

namespace Webkul\Asaas\Payment;

class Card extends Asaas
{
    protected $code = 'asaas_card';

    public function getRedirectUrl()
    {
        return route('asaas.card.redirect');
    }

    public function processCardPayment($cart, $cardData)
    {
        $customerId = $this->createCustomer($cart);

        $paymentData = [
            'customer' => $customerId,
            'billingType' => 'CREDIT_CARD',
            'value' => (float) $cart->grand_total,
            'dueDate' => now()->format('Y-m-d'),
            'description' => "Pedido #{$cart->id}",
            'externalReference' => (string) $cart->id,
            'creditCard' => [
                'holderName' => $cardData['holder_name'],
                'number' => $cardData['number'],
                'expiryMonth' => $cardData['expiry_month'],
                'expiryYear' => $cardData['expiry_year'],
                'ccv' => $cardData['ccv'],
            ],
            'creditCardHolderInfo' => [
                'name' => $cardData['holder_name'],
                'email' => $cart->shipping_address->email,
                'cpfCnpj' => $cardData['cpf_cnpj'],
                'postalCode' => $cart->shipping_address->postcode,
                'addressNumber' => $cardData['address_number'],
                'addressComplement' => $cardData['address_complement'] ?? '',
                'phone' => $this->formatPhone($cart->shipping_address->phone),
            ],
        ];

        $response = $this->asaasClient->post('payments', $paymentData);

        return $response;
    }
}
