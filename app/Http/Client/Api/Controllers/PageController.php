<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * @api {get} /api/pages/:slug Отримання інформації про сторінку
     * @apiName Вміст сторінки
     * @apiGroup Сторінки
     *
     * @apiParam {String} slug Унікальний slug сторінки.
     *
     * @apiSuccess {String} name Назва сторінки.
     * @apiSuccess {String} content Вміст сторінки.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "name": "Назва сторінки",
     *         "content": "Вміст сторінки"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "message": "Сторінку не знайдено"
     *     }
     */

    public function show($slug)
    {
        $page = Page::firstWhere(['slug' => $slug]);

        return new PageResource($page);
    }
}
