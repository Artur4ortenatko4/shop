<?php

namespace App\Http\Client\Web\Controllers;


use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Article;

class FavoriteController extends Controller
{
    public function toggleProduct(Product $product)
    {

        $result = \Favorite::toggle($product);

        return redirect()->back();
    }
    public function listFavorites()
    {
        $user = Auth::user();
        $products = $user->favoriteProducts()->get();
        $articles = $user->favoriteArticles()->get();
        return view('client.favorite.index', compact('products', 'articles'));
    }
    public function toggleArticle(Article $article)
    {
        $result = \Favorite::toggle($article);

        return redirect()->back();
    }
}
