<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CartItem;
use App\Services\ClientServices\CartItemService;
use App\Services\ClientServices\CartService;




class CartController extends Controller
{

    public function index(CartService $cartService)
    {
        $cartId = request()->cookie('cart_id');
        $cartItems = $cartService->mergeGuestCart($cartId);

        return view('client.cart.index', compact('cartItems'));
    }



    public function addToCart($productSlug, CartService $cartService)
    {
        $cartService->addToCart($productSlug);

        return redirect()->back();
    }

    public function remove($itemId, CartItemService $cartItemService)
    {
        $cartItem = CartItem::find($itemId);
        $cartItemService->removeFromCart($cartItem);

        return redirect()->back();
    }
}
