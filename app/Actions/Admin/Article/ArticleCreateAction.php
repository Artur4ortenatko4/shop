<?php

namespace App\Actions\Admin\Article;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Article;
use Illuminate\Support\Arr;

class ArticleCreateAction
{
    use AsAction;


    public function handle(array $data): Article
    {
        // Ваша логіка для створення або оновлення новини

        $articles = Article::create(
            Arr::only($data, [
                'name',
                'content',
                'slug',
                'publication_date',
            ]),
        );
        $articles['publication_date'] = now();

        return $articles;
    }
}
