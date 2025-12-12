<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Events\ConfirmOrder;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(10);

        return view('admin.orders.index',compact('orders'));
    }

    public function confirmOrder($id)
    {
        // Отримайте конкретне замовлення за його ідентифікатором
        $order = Order::findOrFail($id);

        // Відправка події ConfirmOrder
        event(new ConfirmOrder($order));

        return redirect()->back()->with('success', 'Замовлення успішно підтверджено.');
    }
}
