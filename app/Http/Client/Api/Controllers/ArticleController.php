<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;


class ArticleController extends Controller
{
    /**
     * @api {get} /api/articles Отримати всі статті
     * @apiName Отримати новини
     * @apiGroup Новини
     *
     * @apiSuccess {Object[]} articles Масив статей.
     * @apiSuccess {Number} articles.id Унікальний ідентифікатор статті.
     * @apiSuccess {String} articles.title Заголовок статті.
     * @apiSuccess {String} articles.content Вміст статті.
     * @apiSuccess {String} articles.photo URL зображення, якщо воно прикріплене.
     * @apiSuccess {String} articles.created_at Дата та час створення статті.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     [
     *         {
     *             "id": 1,
     *             "title": "Заголовок першої статті",
     *             "content": "Вміст першої статті...",
     *             "photo": "http://example.com/path/to/photo.jpg",
     *             "created_at": "2023-10-20T10:30:00.000000Z"
     *         },
     *         {
     *             "id": 2,
     *             "title": "Заголовок другої статті",
     *             "content": "Вміст другої статті...",
     *             "created_at": "2023-10-20T11:45:00.000000Z"
     *         }
     *     ]
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *         "error": "Помилка при отриманні статей"
     *     }
     */
    public function index()
    {
        $articles = Article::all();

        return ArticleResource::collection($articles);
    }

    /**
     * @api {get} /api/articles/:slug Отримати статтю за слагом
     * @apiName Отримати новину
     * @apiGroup Новини
     *
     * @apiParam {String} slug Унікальний слаг статті.
     *
     * @apiSuccess {Number} id Унікальний ідентифікатор статті.
     * @apiSuccess {String} title Заголовок статті.
     * @apiSuccess {String} content Вміст статті.
     * @apiSuccess {String} photo URL зображення, якщо воно прикріплене.
     * @apiSuccess {String} created_at Дата та час створення статті.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "id": 1,
     *         "title": "Заголовок статті",
     *         "content": "Вміст статті...",
     *         "photo": "http://example.com/path/to/photo.jpg",
     *         "created_at": "2023-10-20T10:30:00.000000Z"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "error": "Статтю не знайдено"
     *     }
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();
        return new ArticleResource($article);
    }
}
