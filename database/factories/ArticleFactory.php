<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
Use App\Models\Article;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'slug' => Str::slug($this->faker->word, '-'),
            'content' => $this->faker->text,
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Article $articles) {
            //
        })->afterCreating(function (Article $article) {

            // Media
            $article->addMediaFromUrl('https://picsum.photos/920/460')
                ->toMediaCollection('photo');
        });
    }
}
