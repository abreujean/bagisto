<?php

namespace Webkul\Asaas\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;

class AsaasController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function success(Request $request)
    {
        $cart = Cart::getCart();

        $data = $this->prepareOrderData($cart);
        $order = $this->orderRepository->create($data);

        Cart::deActivateCart();

        session()->flash('order_id', $order->id);

        return redirect()->route('shop.checkout.onepage.success');
    }

    public function cancel()
    {
        session()->flash('error', 'asaas::asaas.messages.payment_cancelled');

        return redirect()->route('shop.checkout.cart.index');
    }

    protected function prepareOrderData($cart): array
    {
        return (new \Webkul\Sales\Transformers\OrderResource($cart))->jsonSerialize();
    }

    public function webhook(Request $request)
    {
        $this->validateWebhookToken($request);

        $event = $request->input('event');
        $paymentData = $request->input('payment');

        return $this->processWebhookEvent($event, $paymentData);
    }

    protected function validateWebhookToken(Request $request): void
    {
        $token = $request->header('asaas-access-token');

        $expectedToken = core()->getConfigData('sales.payment_methods.asaas.webhook_token');

        if ($token !== $expectedToken) {
            abort(403, 'asaas::asaas.messages.invalid_webhook_token');
        }
    }

    protected function processWebhookEvent($event, $paymentData)
    {
        $helper = new \Webkul\Asaas\Helpers\WebhookHelper;

        switch ($event) {
            case 'PAYMENT_CONFIRMED':
                $helper->handlePaymentConfirmed($paymentData);
                break;
            case 'PAYMENT_RECEIVED':
                $helper->handlePaymentReceived($paymentData);
                break;
            case 'PAYMENT_REFUNDED':
                $helper->handlePaymentRefunded($paymentData);
                break;
            case 'PAYMENT_DELETED':
                $helper->handlePaymentDeleted($paymentData);
                break;
        }

        return response()->json(['status' => 'ok']);
    }
}
