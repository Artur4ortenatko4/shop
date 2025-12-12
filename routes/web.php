<?php

use App\Http\Client\Web\Controllers\CheckOutController;
use App\Http\Client\Web\Controllers\CategoryController;
use App\Http\Client\Web\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Client\Web\Controllers\OrderController;
use App\Http\Client\Web\Controllers\CartController;
use App\Http\Client\Web\Controllers\FavoriteController;
use App\Http\Client\Web\Controllers\PageController;
use App\Http\Client\Web\Controllers\ProductController;
use App\Http\Client\Web\Controllers\ReviewController;
use App\Http\Client\Web\Controllers\SubscriberController;
use App\Http\Client\Web\Controllers\UserController;
use App\Http\Auth\Web\Controllers\LoginController;
use App\Http\Auth\Web\Controllers\RegisterController;
use App\Http\Auth\Web\Controllers\ConfirmPasswordController;


// Пошук
Route::get('/search', [CategoryController::class, 'search'])->name('products.search');

// Новини
Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/article/{slug}/previous', [ArticleController::class, 'previous'])->name('article.previous');
Route::get('/article/{slug}/next', [ArticleController::class, 'next'])->name('article.next');

// Каталог
Route::get('/catalog', [CategoryController::class, 'index'])->name('catalog');

// Продукти категорії
Route::get('/catalog/{slug}', [CategoryController::class, 'show'])->name('category.products');

// Продукт
Route::get('/catalog/{categorySlug}/{productSlug}', [ProductController::class, 'show'])->name('products.show');

// Відгук до продукту
Route::post('/{productSlug}/review/create', [ReviewController::class, 'create'])->name('review.create')->middleware('auth');

// Профіль
Route::get('/my', [UserController::class, 'index'])->name('my');
Route::get('/my/{id}/edit', [UserController::class, 'edit'])->name('my.edit');
Route::put('/my/{id}/update', [UserController::class, 'update'])->name('my.update');

// Розсилка
Route::post('/mailing', [SubscriberController::class, 'mailing'])->name('mailing');


// Фунціонал Корзини
Route::post('/add-product/{slug}', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/add/{slug}', [CartController::class, 'addToCart'])->name('add');
Route::get('/remove-product/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'index']);
// Фунціонал Замовлення
Route::get('/checkout', [CheckOutController::class, 'checkOut']);
Route::get('/suggest/settlements', [OrderController::class, 'cityName']);
Route::get('/suggest/street', [OrderController::class, 'street']);
Route::post('/place', [CheckOutController::class, 'place'])->name('place');
Route::get('/thanks', [CheckOutController::class, 'thanks'])->name('thanks');
// Історія Замовленнь
Route::get('/order-history', [OrderController::class, 'orders']);


// Обрані
Route::middleware(['auth'])->group(function () {
    Route::post('/my/favorites/products/{product}', [FavoriteController::class, 'toggleProduct'])->name('favorite.toggle');
    Route::get('/my/favorites/products', [FavoriteController::class, 'listFavorites'])->name('favorites.show');

    Route::post('/my/favorites/articles/{article}', [FavoriteController::class, 'toggleArticle'])->name('favorites.articles.toggle');
    Route::get('/my/favorites/articles', [FavoriteController::class, 'listFavorites'])->name('favorites.articles.list');
});

// Авторизація

Route::get('/email/verify', [ConfirmPasswordController::class, 'show'])
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [ConfirmPasswordController::class, 'verify'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [ConfirmPasswordController::class, 'sendVerificationNotification'])
    ->name('verification.send');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

require __DIR__ . '/admin.php';

// // Тест Policy
//  Route::get('/test-policy', [AdminUserController::class, 'testPolicy'])->name('test-policy');
// Route::get('/confirm-order/{іd}', [OrderController::class, 'confirmOrder']);

// Статичні сторінки
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/{slug}', [PageController::class, 'show'])->name('page');
