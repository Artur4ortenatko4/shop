<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;


class OrderController extends Controller
{
    /**
     * @api {get} /api/orders Отримання замовлень
     * @apiName Отримання замовлень
     * @apiGroup Замовлення
     *
     * @apiSuccess {Number} id Унікальний ідентифікатор замовлення.
     * @apiSuccess {String} user_name Ім'я користувача, який зробив замовлення.
     * @apiSuccess {String} surname Прізвище користувача, який зробив замовлення.
     * @apiSuccess {String} status Статус замовлення.
     * @apiSuccess {Number} total_amount Загальна сума замовлення.
     * @apiSuccess {Date} created_at Дата створення замовлення.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "id": 1,
     *         "user_name": "Ім'я користувача 1",
     *         "surname": "Прізвище користувача 1",
     *         "status": "Статус замовлення 1",
     *         "total_amount": 99.99,
     *         "created_at": "2023-10-10 15:30:00"
     *     }
     *
     * @apiError NoOrdersFound Помилка: замовлення не знайдено.
     *
     * @apiErrorExample Приклад помилки:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "error": "NoOrdersFound",
     *         "message": "Замовлення не знайдено"
     *     }
     */

    public function orders()
    {
        $orderId = request()->cookie('order_id');


        // Зараз $orderIds - це масив ID, і ви можете використовувати його для запиту до бази даних
        $orders = Order::where('id', $orderId)->first();
        // dd($orders);
        return new OrderResource($orders);
    }
}
