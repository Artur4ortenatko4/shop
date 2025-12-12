<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;


class ProfileController extends Controller
{
    /**
     * @api {get} /api/profile Отримати профіль користувача
     * @apiName Отримати профіль
     * @apiGroup Профіль
     *
     * @apiHeader {String} Authorization Bearer токен користувача.
     *
     * @apiSuccess {Number} id Унікальний ідентифікатор користувача.
     * @apiSuccess {String} name Ім'я користувача.
     * @apiSuccess {String} email Електронна пошта користувача.
     * @apiSuccess {String} phone Номер телефону користувача.
     * @apiSuccess {String} avatar URL аватара користувача, якщо воно є.
     * @apiSuccess {String} created_at Дата створення профілю користувача.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "id": 1,
     *         "name": "Ім'я користувача",
     *         "email": "user@example.com",
     *         "phone": "+1234567890",
     *         "avatar": "http://example.com/path/to/avatar.jpg",
     *         "created_at": "2023-10-10 12:34:56"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 401 Unauthorized
     *     {
     *         "error": "Необхідна авторизація"
     *     }
     */
    public function show()
    {
        $user = auth()->user();

        return new UserResource($user);
    }
    /**
     * @api {put} /api/profile/edit Редагувати профіль користувача
     * @apiName Редагувати Профіль
     * @apiGroup Профіль
     *
     * @apiHeader {String} Authorization Bearer токен користувача.
     *
     * @apiParam {String} [name] Ім'я користувача.
     * @apiParam {String} [email] Електронна пошта користувача.
     * @apiParam {String} [phone] Номер телефону користувача.
     * @apiParam {String} [password] Пароль користувача.
     * @apiParam {String} [avatar] URL нового аватара користувача, якщо воно має бути змінено.
     *
     * @apiSuccess {Number} id Унікальний ідентифікатор користувача.
     * @apiSuccess {String} name Ім'я користувача.
     * @apiSuccess {String} email Електронна пошта користувача.
     * @apiSuccess {String} phone Номер телефону користувача.
     * @apiSuccess {String} avatar URL нового аватара користувача, якщо він був змінений.
     * @apiSuccess {String} updated_at Дата оновлення профілю користувача.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "id": 1,
     *         "name": "Нове ім'я користувача",
     *         "email": "newuser@example.com",
     *         "phone": "+9876543210",
     *         "avatar": "http://example.com/path/to/new-avatar.jpg",
     *         "updated_at": "2023-10-11 08:12:34"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 401 Unauthorized
     *     {
     *         "error": "Необхідна авторизація"
     *     }
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *         "error": "Некоректні дані для оновлення"
     *     }
     */
    public function edit(ProfileRequest $request)
    {
        $user = auth()->user();
        $user->update($request->only(
            'name',
            'phone',
            'email',
            'password',
            // Додайте інші поля для оновлення
        ));
        return new UserResource($user);
    }
}
