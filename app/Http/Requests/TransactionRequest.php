<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'customer_name' => 'required|max:200',
            'customer_email' => 'required|max:100',
            'customer_phone' => 'max:45|nullable',
            'sub_total' => 'required|max:18',
            'total' => 'required|max:18',
            'total_purchase' => 'required|max:18',
            'additional_request' => 'nullable',
            'payment_method' => 'required|max:200',
            'status' => 'required|numeric|min:0|max:2',
            'product_id' => 'required',
            'product_qty' => 'required',
            "voucher" => 'required|numeric',
        ];
    }
}
