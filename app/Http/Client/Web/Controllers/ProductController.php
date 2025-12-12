<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($categorySlug, $productSlug)
    {

        // Знайдіть категорію за допомогою $categorySlug
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        // Знайдіть поточний товар у цій категорії за допомогою $productSlug
        $currentProduct = Product::where('slug', $productSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        $rating = $currentProduct->review->avg('rating');
        $reviews = $currentProduct->review;
        // dd($reviews);
        return view('client.product.show', compact('category', 'currentProduct', 'reviews', 'rating'));
    }
}
