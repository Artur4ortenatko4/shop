<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * @api {get} /api/cart Отримання вмісту корзини користувача
     * @apiName Отримання корзини користувача
     * @apiGroup Корзина
     *
     * @apiSuccess {Object[]} items Масив товарів у корзині.
     * @apiSuccess {String} items.name Назва товару.
     * @apiSuccess {Number} items.quantity Кількість товару в корзині.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "items": [
     *             {
     *                 "name": "Назва товару 1",
     *                 "quantity": 2
     *             },
     *             {
     *                 "name": "Назва товару 2",
     *                 "quantity": 1
     *             }
     *         ]
     *     }
     * }
     */
    public function index()
    {

        // Отримуємо ідентифікатор корзини з кук
        $cartId = request()->cookie('cart_id');

        // Шукаємо корзину за ідентифікатором
        $cartItems = CartItem::where('cart_id', $cartId)->get();

        // Перевіряємо, чи є користувач авторизованим
        if (auth()->check()) {
            // Отримуємо ідентифікатор користувача
            $userId = auth()->user()->id;

            // Знаходимо корзину користувача (якщо вона існує)
            $userCart = Cart::firstOrCreate([
                'user_id' => $userId,
                'id' => $cartId,
            ]);

            $updateCart = CartItem::where('cart_id', $cartId)->update(['cart_id' => $userCart->id]);

            // Отримуємо товари корзини користувача (якщо вони є)
            // $userCartItems = $userCart ? $userCart->cartItems : [];
            $cartItems = CartItem::where('cart_id', $userCart->id)->get();
            // // Об'єднуємо товари з гостьової та користувальницької корзини
            // $cartItems = $cartItems->concat($userCartItems);
        } else {
            $cartItems = CartItem::where('cart_id', $cartId)->get();
        }
        return CartItemResource::collection($cartItems);
    }
    /**
     * @api {post} /api/cart/{slug} Додавання товару до корзини користувача
     * @apiName Додавання товару до корзини
     * @apiGroup Корзина
     *
     * @apiParam {String} slug Унікальний слаг товару.
     *
     * @apiSuccess {String} message Повідомлення про успішне додавання товару до корзини.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "message": "Додано до корзини"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "error": "Товар не знайдено"
     *     }
     */
    public function addToCart($slug)
    {
        // Отримуємо продукт за допомогою слагу (вам може знадобитися налаштувати, яким чином ви будете отримувати продукт)
        $product = Product::where('slug', $slug)->firstOrFail();



        // Отримуємо або створюємо корзину для поточного користувача
        if (auth()->check()) {
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id(),
            ]);
        } else {
            $cart = Cart::firstOrCreate([
                'id' => request()->cookie('cart_id'),
            ]);
        }
        // dd($cart);

        // Перевіряємо, чи товар вже є в корзині
        $existingCartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($existingCartItem) {
            // Якщо товар вже є в корзині, збільшуємо кількість на 1
            $existingCartItem->update([
                'quantity' => $existingCartItem->quantity + 1,
            ]);
        } else {
            // Якщо товару немає в корзині, створюємо новий запис
            $cart = CartItem::firstOrCreate([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }
        return response()->json(['message' => 'Додано до корзини'], 200);
    }
    /**
     * @api {delete} /api/cart/{itemId} Видалення товару з корзини користувача
     * @apiName Видалення товару з корзини
     * @apiGroup Корзина
     *
     * @apiParam {Number} itemId ID товару, який потрібно видалити з корзини.
     *
     * @apiSuccess {String} message Повідомлення про успішне видалення товару з корзини.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "message": "Видалено з корзини"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 404 Not Found
     *     {
     *         "error": "Товар не знайдено в корзині"
     *     }
     */
    public function remove($itemId)
    {
        $cartId = request()->cookie('cart_id');
        // Знаходимо товар корзини за його ID
        $cartItem = CartItem::where('cart_id', $cartId)->where('product_id', $itemId)->first();
        // Видаляємо товар з корзини
        $cartItem->delete();

        return response()->json(['message' => 'Видалено з корзини'], 200);
    }
    /**
     * @api {post} /api/cart/shipping Відправка замовлення з корзини користувача
     * @apiName Відправка замовлення
     * @apiGroup Корзина
     *
     * @apiParam {Number} cart_id ID корзини.
     * @apiParam {Number} total_amount Загальна сума замовлення.
     * @apiParam {String} user_name Ім'я користувача.
     * @apiParam {String} surname Прізвище користувача.
     * @apiParam {String} settlement Місце розташування доставки.
     * @apiParam {String} status Статус замовлення.
     *
     * @apiSuccess {String} message Повідомлення про успішне прийняття замовлення.
     *
     * @apiSuccessExample {json} Успішна відповідь:
     *     HTTP/1.1 200 OK
     *     {
     *         "message": "Замовлення прийнято в обробку"
     *     }
     *
     * @apiErrorExample {json} Помилка:
     *     HTTP/1.1 400 Bad Request
     *     {
     *         "error": "Помилка при створенні замовлення"
     *     }
     */
    public function shipping(Request $request)
    {

        $order = Order::create($request->only(
            'cart_id',
            'total_amount',
            'user_name',
            'surname',
            'settlement',
            'status'
        ));
        return response()->json(['message' => 'Замовлення прийнято в обробку'], 200);
    }
}
