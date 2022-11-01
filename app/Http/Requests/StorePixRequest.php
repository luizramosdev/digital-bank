<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePixRequest extends FormRequest
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
            "type_key" => "required|in:CPF,CNPJ,EMAIL,MOBILE",
            "pix_key"  => "required"
        ];
    }

    public function messages()
    {
        return [
            "type_key.required" => "validation.type_key_required",
            "type_key.in"       => "validation.type_key.in",
            "pix_key.required"  => "validation.pix_key.required"
        ];
    }
}
