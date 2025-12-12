<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Отримайте кількість товарів
        $productCount = Cache::remember('product_count', 300, function () {
            return Product::count();
        });
        // Отримайте кількість замовлень
        $orderCount = Cache::remember('order_count', 300, function () {
            return Order::count();
        });

        // Отримайте кількість підписників
        $subscriberCount = Cache::remember('subscriber_count', 300, function () {
            return Subscriber::count();
        });

        // Отримайте кількість клієнтів (user і seller)
        $clientCount = Cache::remember('client_count', 300, function () {
            return User::whereIn('role', ['user', 'seller'])->count();
        });
        $orders = Order::paginate(10);
        return view('admin.home', compact('orders', 'productCount', 'orderCount', 'subscriberCount', 'clientCount'));
    }

}
