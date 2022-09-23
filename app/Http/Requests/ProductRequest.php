<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_categories_id' => 'required|numeric',
            'name' => 'required|max:200',
            'code' => 'required|max:50',
            'price' => 'required|max:18',
            'purchase_price' => 'required|max:18',
            'short_description' => 'nullable|max:250',
            'description' => 'nullable',
            'status' => 'numeric|min:0|max:1|nullable',
            'new_product' => 'numeric|min:0|max:1|nullable',
            'best_seller' => 'numeric|min:0|max:1|nullable',
            'featured' => 'numeric|min:0|max:1|nullable',
        ];
    }
}
