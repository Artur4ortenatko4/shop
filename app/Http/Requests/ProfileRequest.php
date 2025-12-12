<?php

namespace App\Http\Requests;

use App\Rules\Imagerule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'phone' => 'string|max:20',
            'avatar.*' => 'image|mimes:jpeg,png,jpg,gif|max:10048',
            'email' => 'required|max:255',
            'password'=> 'required'
        ];
    }
}
