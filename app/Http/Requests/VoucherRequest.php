<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'code' => 'required|max:50',
            'type' => 'required|numeric|min:0|max:1',
            'disc_value' => 'required|max:18',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'status' => 'numeric|min:0|max:1|nullable',
        ];
    }
}
