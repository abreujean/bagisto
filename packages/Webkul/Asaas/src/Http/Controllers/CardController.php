<?php

namespace Webkul\Asaas\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Asaas\Payment\Card;
use Webkul\Checkout\Facades\Cart;

class CardController extends AsaasController
{
    public function redirect(Request $request)
    {
        $cart = Cart::getCart();

        return view('asaas::checkout.onepage.card', [
            'cart' => $cart,
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'holder_name' => 'required|string|max:100',
            'number' => 'required|string',
            'expiry_month' => 'required|integer|min:1|max:12',
            'expiry_year' => 'required|integer|min:'.date('Y').'|max:'.(date('Y') + 10),
            'ccv' => 'required|string|min:3|max:4',
            'cpf_cnpj' => 'required|string|min:11|max:14',
            'address_number' => 'required|string',
        ]);

        $cart = Cart::getCart();
        $cardPayment = new Card;

        try {
            $payment = $cardPayment->processCardPayment($cart, $request->all());

            $data = $this->prepareOrderData($cart);
            $order = $this->orderRepository->create($data);

            $this->saveTransaction($order, $payment);

            Cart::deActivateCart();
            session()->flash('order_id', $order->id);

            return redirect()->route('shop.checkout.onepage.success');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    protected function saveTransaction($order, $payment)
    {
        $invoice = $order->invoices->first();

        if (! $invoice) {
            return;
        }

        $this->orderTransactionRepository->create([
            'transaction_id' => $payment['id'],
            'status' => $payment['status'],
            'type' => 'CREDIT_CARD',
            'amount' => $payment['value'],
            'payment_method' => 'asaas_card',
            'order_id' => $order->id,
            'invoice_id' => $invoice->id,
            'data' => json_encode($payment),
        ]);
    }
}
