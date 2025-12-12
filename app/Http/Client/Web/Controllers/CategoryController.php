<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('client.catalog.index', ['categories' => $categories]);
    }

    public function show($slug)
    {
        // Знайдемо категорію за допомогою поля 'slug'
        $category = Category::where('slug', $slug)->firstOrFail();

        // Отримаємо всі категорії (включаючи підкатегорії) для обраної категорії
        $categories = Category::whereDescendantOrSelf($category)->pluck('id');

        // Отримаємо всі продукти, які належать до цих категорій
        $products = Product::whereIn('category_id', $categories)->get();

        // Отримаємо всі підкатегорії (дітей) обраної категорії
        $subcategories = $category->children;

        return view('client.product.index', compact('products', 'category', 'subcategories'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::search($query)
            ->whereHas('categories') // Фільтр для продуктів з категоріями
            ->get();

        return view('client.search.index', compact('products', 'query'));
    }
}
