<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Product extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_categories_id' => 'required|numeric',
            'name' => 'required|max:200',
            'code' => 'required|max:50',
            'price' => 'required|max_digits:18',
            'purchase_price' => 'required|max_digits:18',
            'short_description' => 'nullable|max:250',
            'description' => 'nullable',
            'status' => 'required|numeric|min:0|max:1',
            'new_product' => 'required|numeric|min:0|max:1',
            'best_seller' => 'required|numeric|min:0|max:1',
            'featured' => 'required|numeric|min:0|max:1',
        ];
    }
}
