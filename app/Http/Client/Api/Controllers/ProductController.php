<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @api {get} /api/product/:slug Завантаження продукту
     * @apiName Отримати продукт
     * @apiGroup Продукти
     *
     * @apiParam {String} slug Унікальний ідентифікатор продукту (слаг).
     *
     * @apiSuccess {Object} product Інформація про продукт.
     * @apiSuccess {String} product.name Назва продукту.
     * @apiSuccess {String} product.description Опис продукту.
     * @apiSuccess {String} product.product_photo URL фото продукту.
     * @apiSuccess {Number} product.price Ціна продукту.
     * @apiSuccess {String} product.brand Бренд продукту.
     * @apiSuccess {String} product.article Артикул продукту.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "product": {
     *             "name": "Назва продукту",
     *             "description": "Опис продукту",
     *             "product_photo": "URL фото продукту",
     *             "price": 99.99,
     *             "brand": "Бренд продукту",
     *             "article": "Артикул продукту"
     *         }
     *     }
     *
     * @apiError ProductNotFound Помилка: продукт не знайдено.
     *
     * @apiErrorExample Приклад помилки:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "error": "ProductNotFound",
     *         "message": "Продукт не знайдено"
     *     }
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return new ProductResource($product);
    }
    /**
     * @api {get} /api/products/search Пошук продуктів
     * @apiName Пошук продуктів
     * @apiGroup Продукти
     *
     * @apiParam {String} search Рядок для пошуку продуктів за назвою.
     *
     * @apiSuccess {Object[]} products Масив інформації про знайдені продукти.
     * @apiSuccess {String} products.name Назва продукту.
     * @apiSuccess {String} products.description Опис продукту.
     * @apiSuccess {String} products.product_photo URL фото продукту.
     * @apiSuccess {Number} products.price Ціна продукту.
     * @apiSuccess {String} products.brand Бренд продукту.
     * @apiSuccess {String} products.article Артикул продукту.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "products": [
     *             {
     *                 "name": "Назва продукту 1",
     *                 "description": "Опис продукту 1",
     *                 "product_photo": "URL фото продукту 1",
     *                 "price": 99.99,
     *                 "brand": "Бренд продукту 1",
     *                 "article": "Артикул продукту 1"
     *             },
     *             {
     *                 "name": "Назва продукту 2",
     *                 "description": "Опис продукту 2",
     *                 "product_photo": "URL фото продукту 2",
     *                 "price": 149.99,
     *                 "brand": "Бренд продукту 2",
     *                 "article": "Артикул продукту 2"
     *             }
     *         ]
     *     }
     *
     * @apiError NoProductsFound Помилка: продукти не знайдено.
     *
     * @apiErrorExample Приклад помилки:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "error": "NoProductsFound",
     *         "message": "Продукти не знайдено"
     *     }
     */
    public function search(Request $request)
    {
        $query = $request->input('search');

        $products = Product::where('name', 'like', '%' . $query . '%')->get();
        return ProductResource::collection($products);
    }
}
