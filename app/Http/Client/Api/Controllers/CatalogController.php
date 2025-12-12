<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CatalogResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;


class CatalogController extends Controller
{
    /**
     * @api {get} /api/catalog Отримати всі категорії
     * @apiName Отримати категорії
     * @apiGroup Каталог
     *
     * @apiSuccess {Object[]} categories Масив категорій.
     * @apiSuccess {Number} categories.id Унікальний ідентифікатор категорії.
     * @apiSuccess {String} categories.name Назва категорії.
     * @apiSuccess {String} categories.slug Унікальний слаг категорії.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     [
     *         {
     *             "id": 1,
     *             "name": "Категорія 1",
     *             "slug": "category-1"
     *         },
     *         {
     *             "id": 2,
     *             "name": "Категорія 2",
     *             "slug": "category-2"
     *         }
     *     ]
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *         "error": "Помилка при отриманні категорій"
     *     }
     */
    public function index()
    {
        $categories = Category::all();

        return CatalogResource::collection($categories);
    }

    /**
     * @api {get} /api/catalog/:slug/products Отримати товари категорії
     * @apiName Отримати продукти категорії
     * @apiGroup Каталог
     *
     * @apiParam {String} slug Унікальний слаг категорії.
     *
     * @apiSuccess {Object[]} products Масив товарів категорії.
     * @apiSuccess {Number} products.id Унікальний ідентифікатор товару.
     * @apiSuccess {String} products.name Назва товару.
     * @apiSuccess {String} products.description Опис товару.
     * @apiSuccess {String} products.product_photo URL фото товару, якщо воно є.
     * @apiSuccess {Number} products.price Ціна товару.
     * @apiSuccess {String} products.brand Бренд товару.
     * @apiSuccess {String} products.article Артикул товару.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     [
     *         {
     *             "id": 1,
     *             "name": "Товар 1",
     *             "description": "Опис товару 1...",
     *             "product_photo": "http://example.com/path/to/photo.jpg",
     *             "price": 100.0,
     *             "brand": "Бренд 1",
     *             "article": "A12345"
     *         },
     *         {
     *             "id": 2,
     *             "name": "Товар 2",
     *             "description": "Опис товару 2...",
     *             "price": 80.0,
     *             "brand": "Бренд 2",
     *             "article": "B67890"
     *         }
     *     ]
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "error": "Категорію не знайдено"
     *     }
     */
    public function showProducts($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $categories = Category::whereDescendantOrSelf($category)->pluck('id');

        $products = Product::whereIn('category_id', $categories)->get();

        return ProductResource::collection($products);
    }
}
