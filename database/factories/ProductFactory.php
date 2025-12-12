<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Seller;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $currentPrice = $this->faker->randomFloat(2, 5, 100);
        $oldPrice = $this->faker->randomFloat(2, $currentPrice + 1, $currentPrice + 20);
        return [
            'name' => $this->faker->word,
            'slug' => Str::slug($this->faker->word, '-'),
            'description' => $this->faker->paragraph,
            'price' => $currentPrice,
            'old_price' => $oldPrice,
            'article' => $this->faker->unique()->numberBetween(1000, 9999),
            'seller_id' => Seller::factory(),
            'category_id' => Category::factory(),
            'brand' => $this->faker->word,
        ];
    }
    public function configure()
    {
        return $this->afterMaking(function (product $product) {
            //
        })->afterCreating(function (product $product) {
            $randomPhotoCount = rand(1, 3); // Генеруємо випадкове число від 1 до 3

            for ($i = 0; $i < $randomPhotoCount; $i++) {
                $product->addMediaFromUrl('https://picsum.photos/920/460')
                    ->toMediaCollection('product_photo');
            }
        });
    }
}
