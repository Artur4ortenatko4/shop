<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Admin\Requests\AttributRequest;
use App\Models\Attribute;
use App\Models\Category;

class AttributController extends Controller
{
    public function index()
    {
        $attributs = Attribute::with('categories')->paginate(10);
        return view('admin.attribut.index', compact('attributs'));
    }

    public function create()
    {
        $categories = Category::with('categories')->pluck('name', 'id')->toArray();
        return view('admin.attribut.create', compact('categories'));
    }

    public function store(AttributRequest $request)
    {
        $attributs = Attribute::create([
            'name' => $request->input('name'),
        ]);
        $categories = $request->input('categories');

        $attributs->categories()->attach($categories);

        return redirect()->route('admin.attribut.index');
    }
    public function show($id)
    {
        $attributs = Attribute::findOrFail($id);
        $categories = Category::with('categories')->pluck('name', 'id')->toArray();

        return view('admin.attribut.edit', compact('attributs', 'categories'));
    }

    public function edit()
    {
        //
    }
    public function update(AttributRequest $request, $id)
    {
        $attributs = Attribute::findOrFail($id);
        $attributs->update([
            'name' => $request->input('name'),
        ]);
        $categories = $request->input('categories');

        $attributs->categories()->attach($categories);


        return redirect()->route('admin.attribut.index');
    }

    public function destroy($id)
    {
        $attributs = Attribute::findOrFail($id);
        $attributs->delete();
        return redirect()->route('admin.attribut.index');
    }
}
