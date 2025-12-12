<?php

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Requests\ReviewRequest;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;


class ReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::with(['product', 'user'])->paginate(20);
        return view('admin.review.index', compact('reviews'));
    }
    public function create()
    {
        $products = Product::pluck('name', 'id')->toArray();
        return view('admin.review.create', compact('products'));
    }

    public function store(ReviewRequest $request)
    {
        $user = auth()->user(); // Отримати автентифікованого користувача

        $review = Review::create([
            $request->only(
                'product_id',
                'content',
                'rating',
            ),
            'user_id' => $user->id
        ]);
        return redirect()->route('admin.review.index');
    }
    public function show()
    {
    }
    public function edit($id)
    {
        $reviews = Review::findOrFail($id);
        $products = Product::pluck('name', 'id')->toArray();
        return view('admin.review.edit', compact('reviews', 'products'));
    }
    public function update(ReviewRequest $request, $id)
    {
        $reviews = Review::findOrFail($id);
        $reviews->update(
            $request->only(
                'product_id',
                'content',
                'rating'
            )
        );
        // Зберігаємо зміни в базі даних
        $reviews->save();

        return redirect()->route('admin.review.index');
    }

    public function destroy($id)
    {
        $reviews = Review::findOrFail($id);
        $reviews->delete();
        return redirect()->route('admin.review.index');
    }
}
