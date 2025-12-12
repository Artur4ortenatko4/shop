<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::firstWhere(['slug' => 'home']);

        return view('client.pages.' . $page->template, ['page' => $page]);
    }

    public function show($slug)
    {
        $page = Page::firstWhere(['slug' => $slug]);

        return view('client.pages.' . $page->template, ['page' => $page]);
    }
}
