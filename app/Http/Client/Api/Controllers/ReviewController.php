<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;


class ReviewController extends Controller
{

    /**
     * @api {get} /api/products/{slug}/reviews Отримати відгуки про продукт
     * @apiName Отримати Відгуки
     * @apiGroup Відгуки
     *
     * @apiParam {String} slug Унікальний слаг продукту.
     *
     * @apiSuccess {Object[]} reviews Масив відгуків.
     * @apiSuccess {String} reviews.name Ім'я користувача, який залишив відгук.
     * @apiSuccess {String} reviews.content Зміст відгука.
     * @apiSuccess {Number} reviews.rating Рейтинг відгука.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     [
     *         {
     *             "name": "Ім'я користувача 1",
     *             "content": "Зміст відгука 1",
     *             "rating": 5
     *         },
     *         {
     *             "name": "Ім'я користувача 2",
     *             "content": "Зміст відгука 2",
     *             "rating": 4
     *         }
     *     ]
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "error": "Продукт не знайдено"
     *     }
     */

    public function show($slug)
    {

        $product = Product::where('slug', $slug)->first();

        $reviews = Review::where('product_id', $product->id)->with('user')->get();

        return ReviewResource::collection($reviews);
    }
}
