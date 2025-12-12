<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest('created_at')->paginate(6);
        return view('client.article.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('client.article.show', compact('article'));
    }

    public function previous($slug)
    {
        $article = Article::where('slug', '<', $slug)->latest('slug')->firstOrFail();
        return view('client.article.show', compact('article'));
    }

    public function next($slug)
    {
        $article = Article::where('slug', '>', $slug)->oldest('slug')->firstOrFail();
        return view('client.article.show', compact('article'));
    }
}
