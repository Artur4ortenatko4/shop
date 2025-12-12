<?php

namespace App\Http\Admin\Controllers;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Admin\Requests\ProductRequest;
use App\Models\Category;
use App\Imports\ProductsImport;
use App\Models\Attribute;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('categories', 'media');
        $categoryFilter = $request->input('categories');

        $query->when($request->input('name'), function ($q, $nameFilter) {
            return $q->where('name', 'like', '%' . $nameFilter . '%');
        });

        $query->when($request->input('min_price') && $request->input('max_price'), function ($q) use ($request) {
            return $q->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
        });

        $query->when($categoryFilter, function ($q) use ($categoryFilter) {
            return $q->whereHas('categories', function ($subquery) use ($categoryFilter) {
                $subquery->whereIn('id', $categoryFilter);
            });
        });

        $query->when($request->input('with_photo'), function ($q) {
            return $q->whereHas('media', function ($subquery) {
                $subquery->where('collection_name', 'product_photo');
            });
        });

        $sortField = $request->input('sort_field', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');

        if ($request->has('reset_sort')) {
            $products = $query->latest()->paginate(10);
        } else {
            $products = $query->orderBy($sortField, $sortDirection)->paginate(10);
        }

        $attributes = Attribute::pluck('name', 'id');
        $categories = Category::pluck('name', 'id')->toArray();

        return view('admin.product.index', compact('products', 'attributes', 'categories', 'categoryFilter', 'sortField', 'sortDirection'));
    }


    public function create()
    {
        $attributs = Attribute::pluck('name', 'id')->toArray();
        $seller = User::where('role', 'seller')->pluck('name', 'id')->toArray();
        $categories = Category::all()->pluck('name', 'id')->toArray();
        return view('admin.product.create', compact('categories', 'seller', 'attributs'));
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->only(
            'name',
            'description',
            'price',
            'old_price',
            'article',
            'category_id',
            'brand',
            'seller_id',
            'slug',
        ));
        $attribut = $request->input('attributs');
        $value = $request->input('value');

        // За допомогою зв'язку "properties" створюємо новий запис у таблиці "properties"
        $property = $product->properties()->create([
            'attribute_id' => $attribut,
            'value' => $value, // Використовуємо значення для атрибуту
        ]);

        return redirect()->route('admin.product.index');
    }

    public function show($id)
    {
        $attributs = Attribute::pluck('name', 'id')->toArray();
        $seller = User::where('role', 'seller')->pluck('name', 'id')->toArray();
        $categories = Category::all()->pluck('name', 'id')->toArray();
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('product', 'categories', 'seller', 'attributs'));
    }

    public function edit()
    {
        //
    }
    public function update(ProductRequest $request, $id)
    {

        $product = Product::findOrFail($id);
        $product->update($request->only(
            'name',
            'description',
            'price',
            'old_price',
            'article',
            'category_id',
            'brand',
            'slug',

        ));
        $attribut = $request->input('attributs');
        $value = $request->input('value');

        // За допомогою зв'язку "properties" створюємо новий запис у таблиці "properties"
        $property = $product->properties()->create([
            'attribute_id' => $attribut,
            'values' => $value, // Використовуємо значення для атрибуту
        ]);

        $product->mediaManage($request);

        return redirect()->route('admin.product.index');
    }

    public function destroy($id)
    {
        $product = product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.product.index');
    }
    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
    public function import(Request $request)
    {
        // Перевіряємо, чи був відправлений файл
        if ($request->hasFile('import_file')) {
            $file = $request->file('import_file');

            // Перевіряємо, чи файл є файлом Excel (наприклад, формат xlsx)
            if ($file->getClientOriginalExtension() === 'xlsx') {
                // Завантажуємо файл і викликаємо імпорт
                Excel::import(new ProductsImport, $file);

                return redirect()->back()->with('success', 'Все добре!');
            }
        }

        // Якщо файл не було завантажено або формат невірний, повертаємо назад з повідомленням про помилку
        return redirect()->back()->with('error', 'Файл не завантажено');
    }
}
