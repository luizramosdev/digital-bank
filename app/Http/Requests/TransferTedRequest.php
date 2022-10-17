<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferTedRequest extends FormRequest
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
            "to_account" => "required",
            "amount" => "required|numeric",
            "type_transfer" => "required|in:TED"
        ];
    }

    public function messages()
    {
        return [
            "to_account.required" => "validation.to_account.required",
            "amount.required" => "validation.amount.required",
            "amount.numeric" => "validation.amount.numeric",
            "type_transfer.required" => "validation.type_transfer.required",
            "type_transfer.in" => "validation.type_transfer.in"
        ];
    }
}
