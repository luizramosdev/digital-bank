<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BilletPaymentRequest extends FormRequest
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
            'bar_code' => 'required|numeric',
        ];
    }

    public function message()
    {
        return [
            'bar_code.required' => 'validation.bar_code.required',
            'bar_code.numeric'  => 'validation.bar_code.numeric'
        ];
    }
}
