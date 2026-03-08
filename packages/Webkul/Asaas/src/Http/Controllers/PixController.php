<?php

namespace Webkul\Asaas\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Asaas\Payment\Pix;
use Webkul\Checkout\Facades\Cart;

class PixController extends AsaasController
{
    public function redirect(Request $request)
    {
        $cart = Cart::getCart();
        $pixPayment = new Pix;

        $customerId = $this->findOrCreateCustomer($cart, $pixPayment);
        $payment = $pixPayment->createPayment($cart, $customerId, 'PIX');

        session()->put('asaas_payment_id', $payment['id']);

        $qrData = $pixPayment->getQrCodeData($payment['id']);

        return view('asaas::checkout.onepage.pix', [
            'qrCodeBase64' => $qrData['encodedImage'],
            'qrCodePayload' => $qrData['payload'],
            'invoiceUrl' => $qrData['invoiceUrl'],
            'paymentId' => $payment['id'],
            'cart' => $cart,
            'status' => $qrData['status'],
        ]);
    }

    public function checkStatus(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $pixPayment = new Pix;

        $data = $pixPayment->getQrCodeData($paymentId);

        return response()->json([
            'status' => $data['status'] ?? 'PENDING',
            'qr_code' => $data['payload'] ?? null,
        ]);
    }
}
