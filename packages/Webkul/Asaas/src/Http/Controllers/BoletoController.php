<?php

namespace Webkul\Asaas\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Asaas\Payment\Boleto;
use Webkul\Checkout\Facades\Cart;

class BoletoController extends AsaasController
{
    public function redirect(Request $request)
    {
        $cart = Cart::getCart();
        $boletoPayment = new Boleto;

        $customerId = $this->findOrCreateCustomer($cart, $boletoPayment);
        $payment = $boletoPayment->createPayment($cart, $customerId, 'BOLETO');

        session()->put('asaas_payment_id', $payment['id']);

        $boletoData = $boletoPayment->getBoletoData($payment['id']);

        return view('asaas::checkout.onepage.boleto', [
            'boletoUrl' => $boletoData['invoiceUrl'],
            'bankSlipUrl' => $boletoData['bankSlipUrl'],
            'dueDate' => $boletoData['dueDate'],
            'paymentId' => $payment['id'],
            'cart' => $cart,
            'status' => $boletoData['status'],
        ]);
    }

    public function printBoleto(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $boletoPayment = new Boleto;
        $boletoData = $boletoPayment->getBoletoData($paymentId);

        return redirect($boletoData['bankSlipUrl'] ?? $boletoData['invoiceUrl']);
    }
}
