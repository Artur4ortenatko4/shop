<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteArticleResource;
use App\Http\Resources\FavoriteProductResource;
use App\Models\Article;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * @api {post} /api/favorites/toggleProduct/{slug} Додавання / видалення продукту до / з обраних
     * @apiName Додавання / видалення продукту до / з обраних
     * @apiGroup Обрані
     *
     * @apiParam {String} slug Унікальний slug продукту, який ви хочете додати / видалити.
     *
     * @apiSuccess {String} message Повідомлення про стан продукту в обраних. "Додано до обраних" або "Видалено з обраних".
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "message": "Додано до обраних"
     *     }
     */

    public function toggleProduct($slug)
    {

        $product = Product::where('slug', $slug)->firstOrFail(); // Змініть знаходження продукту за slug

        $result = \Favorite::toggle($product);

        if ($result) {
            return response()->json(['message' => 'Додано до обраних'], 200);
        } else {
            return response()->json(['message' => 'Видалено з обраних'], 200);
        }
    }
    /**
     * @api {get} /api/favorites Отримання обраних продуктів та статей користувача
     * @apiName Отримання обраних продуктів та статей
     * @apiGroup Обрані
     *
     * @apiSuccess {Object} products Масив обраних продуктів користувача.
     * @apiSuccess {Object} articles Масив обраних статей користувача.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "products": [
     *             {
     *                 "name": "Назва продукту",
     *                 "description": "Опис продукту",
     *                 "product_photo": "URL фото продукту",
     *                 "price": 10.99,
     *                 "brand": "Бренд продукту",
     *                 "article": "Артикул продукту"
     *             },
     *             // інші обрані продукти
     *         ],
     *         "articles": [
     *             {
     *                 "name": "Назва статті",
     *                 "content": "Зміст статті",
     *                 "photo": "URL фото статті",
     *                 "created_at": "Дата створення статті"
     *             },
     *             // інші обрані статті
     *         ]
     *     }
     * }
     */
    public function favorites()
    {

        $user = auth()->user();
        $products = $user->favoriteProducts()->get();
        $articles = $user->favoriteArticles()->get();

        return [
            'products' => FavoriteProductResource::collection($products),
            'articles' => FavoriteArticleResource::collection($articles),
        ];
    }
    /**
     * @api {post} /api/favorites/toggleArticle/{slug} Додавання / видалення статті до / з обраних
     * @apiName Додавання / видалення статті до / з обраних
     * @apiGroup Обрані
     *
     * @apiParam {String} slug Унікальний slug статті, яку ви хочете додати / видалити.
     *
     * @apiSuccess {String} message Повідомлення про стан статті в обраних. "Додано до обраних" або "Видалено з обраних".
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "message": "Додано до обраних"
     *     }
     */
    public function toggleArticle($slug)
    {
        $articles = Article::where('slug', $slug)->firstOrFail(); // Змініть знаходження продукту за slug

        $result = \Favorite::toggle($articles);

        if ($result) {
            return response()->json(['message' => 'Додано до обраних'], 200);
        } else {
            return response()->json(['message' => 'Видалено з обраних'], 200);
        }
    }
}
