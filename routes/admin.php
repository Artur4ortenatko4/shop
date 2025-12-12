<?php

use App\Http\Admin\Controllers\OrderController;
use App\Http\Admin\Controllers\UserController;
use App\Http\Admin\Controllers\ArticleController;
use App\Http\Admin\Controllers\ProductController;
use App\Http\Admin\Controllers\AttributController;
use App\Http\Admin\Controllers\CategoryController;
use App\Http\Admin\Controllers\LogController;
use App\Http\Admin\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;
use App\Http\Admin\Controllers\MainController;
use App\Http\Admin\Controllers\PageController;
use App\Http\Admin\Controllers\ReviewController;
use App\Http\Admin\Controllers\SettingController;
use App\Http\Admin\Controllers\SitemapController;

Route::group(['prefix' => 'admin', 'middleware' => 'checkRole:admin', 'as' => 'admin.'], function () {
    Route::get('/', [MainController::class, 'index']);
    Route::resource('page', PageController::class);
    Route::get('/export', [ProductController::class, 'export'])->name('product.export');
    Route::post('/import', [ProductController::class, 'import'])->name('product.import');
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs.index');
    Route::get('log', [LogController::class, 'index']);
    Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
    Route::get('setting', [SettingController::class, 'info'])->name('info');
    Route::put('setting/create', [SettingController::class, 'create'])->name('setting.create');
    Route::get('profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('profile/{id}/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::resource('users', UserController::class);
    Route::resource('article', ArticleController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/order', [CategoryController::class, 'order'])->name('categories.order');
    Route::resource('product', ProductController::class);
    Route::resource('attribut', AttributController::class);
    Route::resource('subscriber', SubscriberController::class);
    Route::resource('review', ReviewController::class);
    Route::get('orders', [OrderController::class, 'index']);

    Route::get('sitemap.xml', [SitemapController::class, 'viewSitemap'])->name('sitemap');

});
