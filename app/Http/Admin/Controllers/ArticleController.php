<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Admin\Requests\ArticleRequest;
use App\Models\Article;
use App\Actions\Admin\Article\ArticleCreateAction;
use App\Actions\Admin\Article\ArticleUpdateAction;
class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('media')->paginate(10);
        return view('admin.article.index', ['articles' => $articles]);
    }

    public function create()
    {
        return view('admin.article.create');
    }

    public function store(ArticleRequest $request)
    {
        $article = ArticleCreateAction::run($request->all());
        $article->mediaManage($request);
        return redirect()->route('admin.article.index');
    }

    public function show($id)
    {
        $articles = Article::findOrFail($id);
        return view('admin.article.edit', compact('articles'));
    }

    public function edit()
    {
    }
    public function update(ArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        ArticleUpdateAction::run($article, $request->all());
        $article->mediaManage($request);

        return redirect()->route('admin.article.index');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('admin.article.index');
    }
}
