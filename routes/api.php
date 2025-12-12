<?php

use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/{slug}', [PageController::class, 'show']);

Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/login', [UserController::class, 'login']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/article/{slug}', [ArticleController::class, 'show']);

Route::get('/catalog', [CatalogController::class, 'index']);
Route::get('/catalog/{slug}', [CatalogController::class, 'showProducts']);

Route::get('/products', [ProductController::class, 'search']);

Route::get('/product/{slug}', [ProductController::class, 'show']);
Route::get('/product/{slug}/reviews', [ReviewController::class, 'show']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/{productSlug}/add', [CartController::class, 'addToCart']);
Route::post('/cart/{itemId}/remove', [CartController::class, 'remove']);

Route::post('cart/shipping', [CartController::class, 'shipping']);
Route::get('orders', [OrderController::class, 'orders']);
Route::post('subscriber', [SubscriberController::class, 'subscriber']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/my/profile', [ProfileController::class, 'show']);
    Route::put('/my/profile/edit', [ProfileController::class, 'edit']);
    Route::post('/my/product/{slug}/favorite', [FavoriteController::class, 'toggleProduct']);
    Route::post('/my/article/{slug}/favorite', [FavoriteController::class, 'toggleArticle']);
    Route::get('/my/product/favorites', [FavoriteController::class, 'favorites']);

    Route::get('/my', function (Request $request) {
        return $request->user();
    });
});



Route::get('/my/{id}/edit', [UserController::class, 'edit'])->name('my.edit');
Route::put('/my/{id}/update', [UserController::class, 'update'])->name('my.update');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/mailing', [MailingController::class, 'mailing'])->name('mailing');
