<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Http\Client\Web\Requests\OrderRequest;
use App\Services\ClientServices\OrderService;
use Illuminate\Support\Facades\Config;

class CheckOutController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function checkOut()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->user()->id)->first();
            $cartItems = CartItem::where('cart_id', $cart->id)->get();
        } else {
            $cartItems = CartItem::where('cart_id', request()->cookie('cart_id'))->get();
        }
        return view('client.checkout.checkout', compact('cartItems'));
    }

    public function place(OrderRequest $request)
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->user()->id)->first();
            $cartId = $cart->id;
        } else {
            $cartId = request()->cookie('cart_id');
        }

        $cartItems = CartItem::where('cart_id', $cartId)->get();
        $total = \Cart::total($cartItems);

        $order = $this->orderService->createOrder($cartId, $total, $request);
        $this->orderService->updateOrderCookie($order);
        $this->orderService->deleteCartItems($cartId);

        $total = (int) ($total * 100);
        \Cloudipsp\Configuration::setMerchantId(Config::get('currency.merchant_id'));
        \Cloudipsp\Configuration::setSecretKey(Config::get('currency.secret_key'));
        $data = [
            'order_desc' => 'tests SDK',
            'currency' => 'UAH',
            'amount' => $total,
            'response_url' => '/thanks',
            'server_callback_url' => 'http://site.com/callbackurl',
            'sender_email' => 'gobsekilich@gmail.com',
            'lang' => 'ua',
            'lifetime' => 36000,
        ];
        $url = \Cloudipsp\Checkout::url($data);
        $data = $url->getData();

        return redirect($data['checkout_url']);
    }
    public function thanks()
    {
        return view('client.cart.thanks');
    }
}
