<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:companies',
            'name' => 'required|string|max:50',
            'password' => 'required|min:6',
            'min_order_sum' => 'required|numeric',
            'phone' => 'required|numeric',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000' 
        ];
    }
}
