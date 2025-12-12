<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Location;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders()
    {
        if (auth()->check()) {
            $cartId = Cart::where('user_id', auth()->user()->id)->first();

            $orders = Order::where('cart_id', $cartId->id)->get();
            // dd($orderIds);
        } else {
            $orderId = request()->cookie('order_id');
            // dd($orderId);
            $orderIds = json_decode($orderId);
            $orders = Order::whereIn('cart_id', $orderIds)->get();
        }
        // Зараз $orderIds - це масив ID, і ви можете використовувати його для запиту до бази даних

        // $orders = Order::where('id', $orderId[])->get();
        return view('client.checkout.order-history', compact('orders'));
    }
    public function cityName(Request $request)
    {
        $query = $request->input('q');
        // Виконайте запит до бази даних, щоб отримати населені пункти, які відповідають запиту
        $settlements = Location::where('city_name', 'LIKE', '%' . $query . '%')
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'text' => implode(' , ', array_filter([$a->city_name, $a->region_name,  $a->street_name])),
                ];
            })
            ->toArray();
        return response()->json(['results' => $settlements]);
    }
}
