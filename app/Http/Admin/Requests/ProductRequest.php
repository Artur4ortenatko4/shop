<?php

namespace App\Http\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\imagerule;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:255',
            'brand' => 'required|max:255',
            'article' => 'required|max:15',
            'old_price' => 'max:7',
            'price' => 'required|max:7',
            'description' => 'required|max:6000',
            'category_id' => 'required',
            'product_photo' => [new Imagerule],
            'product_photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:10048',
            'attributs' => 'required',
            'value' => 'required'
        ];
    }
}
