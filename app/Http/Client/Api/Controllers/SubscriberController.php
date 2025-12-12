<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * @api {post} /api/subscriber Підписка на розсилку
     * @apiName Підписка
     * @apiGroup Розсилка
     *
     * @apiParam {String} name Ім'я підписника.
     * @apiParam {String} email Email адреса підписника.
     *
     * @apiSuccess {String} message Повідомлення про успішну підписку.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "message": "Вас додано до розсилки"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *         "error": "Не вдалося створити підписку"
     *     }
     */

    public function subscriber(Request $request)
    {
        $subscriber = Subscriber::create($request->only(
            'name',
            'email'
        ));
        return response()->json(['message' => 'Вас додано до розсилки'], 200);
    }
}
