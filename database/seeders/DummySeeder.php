<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Article;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Property;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Subscriber;
use App\Models\User;

class DummySeeder extends Seeder
{
    /**
     * Наповнення всіх потребуючих таблиць випадковими данними та створення статичних сторінок
     */
    public function run(): void
    {
        Page::create([
            'id' => '2',
            'name' => 'Про нас',
            'content' => 'Українці — слов\'янський народ, основне й автохтонне населення України, найбільша етнічна спільнота на її території. Як етнос сформувався на землях сучасної України та частин суміжних земель сучасних: Польщі, Білорусі, Молдови, Румунії, Угорщини, Словаччини.',
            'slug' => 'about',
            'template' => 'about',
        ]);
        Page::create([
            'id' => '3',
            'name' => 'Контакти',
            'content' => 'Наші контакти',
            'slug' => 'contacts',
            'template' => 'contacts',
        ]);


        User::factory(10)->create();
        Seller::factory(10)->create()
            ->each(function (Seller $seller) {
                $products = Product::factory(rand(4, 10))->create([
                    'seller_id' => $seller->id
                ]);
                $attributes = Attribute::factory(rand(2, 4))->create();
                $properties =  Property::factory(count($attributes))->create();
                $categories = Category::factory(rand(1, 3))->create();
                $categories->each(function ($category) use ($attributes) {
                    $category->attributes()->attach($attributes->random(rand(1, 2))->pluck('id'));
                });
                $properties->each(function ($property) use ($products) {
                    $property->products()->attach($products->random(rand(1, 2))->pluck('id'));
                });
            });

        Subscriber::factory(10)->create();
        Review::factory(10)->create();
        Cart::factory(10)->create();
        Order::factory(10)->create();
        Article::factory(10)->create();
    }
}
