<?php

namespace App\Http\Auth\Api\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Auth\Api\Requests\LoginRequest;
use App\Http\Auth\Api\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * @api {post} /api/login Авторизація користувача
     * @apiName Авторизація
     * @apiGroup Користувачі
     *
     * @apiParam {String} email Email адреса користувача.
     * @apiParam {String} password Пароль користувача.
     *
     * @apiSuccess {String} token Токен для доступу до API.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "token": "example_token_value"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 401 Unauthorized
     *     {
     *         "message": "Невірний логін або пароль"
     *     }
     */

    public function login(LoginRequest $request)
    {
        // Аутентифікація користувача
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Невірний логін або пароль'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
    /**
     * @api {post} /api/register Реєстрація користувача
     * @apiName Реєстрація
     * @apiGroup Користувачі
     *
     * @apiParam {String} name Ім'я користувача.
     * @apiParam {String} email Email адреса користувача.
     * @apiParam {String} password Пароль користувача.
     *
     * @apiSuccess {String} token Токен для доступу до API.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "token": "example_token_value"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *         "error": "Користувач з таким емайлом існує"
     *     }
     */

    public function register(RegisterRequest $request)
    {


        $email = $request->email;
        $email = User::where('email', $email)->first();
        if ($email) {
            return response()->json(['message' => 'Користувач з таким емайлом існує']);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return new UserResource($user);
    }
}
