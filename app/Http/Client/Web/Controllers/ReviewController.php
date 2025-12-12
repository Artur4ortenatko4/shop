<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Client\Web\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;


class ReviewController extends Controller
{

    public function create(ReviewRequest $request, $productSlug)
    {
        $product = Product::where('slug', $productSlug)->firstOrFail();
        $productId = $product->id;
        $review = Review::create([
            'user_id' => auth()->user()->id,
            'product_id' => $productId,
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
        ]);
        return redirect()->back();
    }
}
