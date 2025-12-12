<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SettingController extends Controller
{

    public function info()
    {
        $values = \Variable::all();
        return View::make('admin.setting.info', compact('values'));
    }
    public function create(Request $request)
    {
        \Variable::save('facebook', $request->input('facebook'));
        \Variable::save('twitter', $request->input('twitter'));
        \Variable::save('instagram', $request->input('instagram'));
        \Variable::save('linkedin', $request->input('linkedin'));
        \Variable::save('address', $request->input('address'));
        \Variable::saveArray('phones', $request->input('phones'));
        \Variable::save('email', $request->input('email'));
        \Cache::forget('laravel.variables.cache');
        return redirect()->route('admin.info')->with('success', 'Змінні успішно збережено');
    }
}
