<?php

namespace App\Http\Client\Web\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'email' => 'required|min:6|max:255',
            'surname' => 'required',
            'phone' => 'required|string|max:20',
            'settlement'=>'required'
        ];
    }
}
