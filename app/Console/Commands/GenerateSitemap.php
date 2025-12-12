<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate a sitemap for the website';

    public function handle()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Додайте силки на сторінки вашого сайту, товари та категорії
        $this->addPagesToSitemap($sitemap);
        $this->addArticleToSitemap($sitemap);
        $this->addCategoriesToSitemap($sitemap);
        $this->addProductsToSitemap($sitemap);


        $sitemap .= '</urlset>';

        // Збережіть sitemap у файл sitemap.xml
        File::put(public_path('sitemap.xml'), $sitemap);

        $this->info('Sitemap generated successfully.');
    }

    protected function addPagesToSitemap(&$sitemap)
    {
        // Додайте силки на сторінки вашого сайту
        // Наприклад:
        $pages = Page::all();
        foreach ($pages as $page) {
            $sitemap .= '<url>' . PHP_EOL;
            $sitemap .= '    <loc>' . route('page', $page->slug) . '</loc>' . PHP_EOL;
            $sitemap .= '    <lastmod>' . $page->updated_at->toW3cString() . '</lastmod>' . PHP_EOL;
            $sitemap .= '</url>' . PHP_EOL;
        }
        // Додайте інші силки на сторінки

    }
    protected function addArticleToSitemap(&$sitemap)
    {
        // Додайте силки на товари вашого сайту
        // Наприклад:
        $articls = Article::all();
        foreach ($articls as $article) {
            $sitemap .= '<url>' . PHP_EOL;
            $sitemap .= '    <loc>' . route('article.show', $article->slug) . '</loc>' . PHP_EOL;
            $sitemap .= '    <lastmod>' . $article->updated_at->toW3cString() . '</lastmod>' . PHP_EOL;
            $sitemap .= '</url>' . PHP_EOL;
        }
        // Додайте інші силки на товари
    }

    protected function addProductsToSitemap(&$sitemap)
    {
        // Додайте силки на товари вашого сайту
        // Наприклад:
        $categories = Category::all();

        foreach ($categories as $category) {
            $productsInCategory = $category->product; // Assuming you have a relationship set up between Category and Product models
            if ($productsInCategory) {
                foreach ($productsInCategory as $product) {
                    $sitemap .= '<url>' . PHP_EOL;
                    $sitemap .= '    <loc>' . route('products.show', ['categorySlug' => $category->slug, 'productSlug' => $product->slug]) . '</loc>' . PHP_EOL;
                    $sitemap .= '    <lastmod>' . $product->updated_at->toW3cString() . '</lastmod>' . PHP_EOL;
                    $sitemap .= '</url>' . PHP_EOL;
                }
            }
        }
        // Додайте інші силки на товари
    }

    protected function addCategoriesToSitemap(&$sitemap)
    {
        // Додайте силки на категорії вашого сайту
        // Наприклад:
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap .= '<url>' . PHP_EOL;
            $sitemap .= '    <loc>' . route('category.products', $category->slug) . '</loc>' . PHP_EOL;
            $sitemap .= '    <lastmod>' . $category->updated_at->toW3cString() . '</lastmod>' . PHP_EOL;
            $sitemap .= '</url>' . PHP_EOL;
        }
        // Додайте інші силки на категорії
    }
}
