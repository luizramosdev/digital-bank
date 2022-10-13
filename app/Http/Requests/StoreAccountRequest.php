<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
            "users.first_name" => "required|string|min:3",
            "users.last_name" => "required|string|min:3",
            "users.date_of_birth" => 'required',
            "users.type_document" => "required|in:CPF,CNPJ",
            "users.document" => "required|numeric|unique:users,document",
            "users.identity_document" => "required|numeric|unique:users,identity_document",
            "users.mothers_name" => "required|string",
            "users.genre" => "required|in:MALE,FEMALE,OTHER",
            "users.mobile" => "required|numeric|digits:11",
            "users.email" => "required|email|unique:users,email",
            "users.password" => "required|min:6",

            "address.zip_code" => "required|numeric",
            "address.street" => "required|string",
            "address.number" => "required|numeric",
            "address.complement" => "string",
            "address.neighborhood" => "required|string",
            "address.city" => "required|string",
            "address.state" => "required|string",
        ];
    }

    public function messages()
    {
        return [
            "users.first_name.required" => "validation.users.first_name.required",
            "users.first_name.string" => "validation.users.first_name.string",

            "users.last_name.required" => "validation.users.last_name.required",
            "users.last_name.string" => "validation.users.last_name.string",

            "users.date_of_birth.required" => "validation.users.date_of_birth.required",

            "users.type_document.required" => "validation.users.type_document.required",
            "users.type_document.in" => "validation.users.type_document.in",

            "users.document.required" =>  "validation.users.document.required",
            "users.document.numeric" => "validation.users.document.numeric",
            "users.document.unique" => "validation.users.document.unique",

            "users.identity_document.required" => "validation.users.identity_document.required",
            "users.identity_document.numeric" => "validation.users.identity_document.numeric",
            "users.identity_document.unique" => "validation.users.identity_document.unique",

            "users.mothers_name.required" => "validation.users.mothers_name.required",
            "users.mothers_name.string" => "validation.users.mothers_name.string",

            "users.genre.required" => "validation.users.genre.required",
            "users.genre.in" => "validation.users.genre.in",

            "users.mobile.required" => "validation.users.mobile.required",
            "users.mobile.numeric" => "validation.users.mobile.numeric",
            "users.mobile.digits" => "validation.users.mobile.digits",

            "users.email.required" => "validation.users.email.required",
            "users.email.email" => "validation.users.email",
            "users.email.unique" => "validation.users.email.unique",

            "users.password.required" => "validation.users.password.required",
            "users.password.min" => "validation.users.password.min",

            "address.zip_code.required" => "validation.address.zip_code.required",
            "address.zip_code.numeric" => "validation.address.zip_code.numeric",

            "address.street.required" => "validation.address.street.required",
            "address.street.string" => "validation.address.street.string",

            "address.number.required" => "validation.address.number.required",
            "address.number.numeric" => "validation.address.number.numeric",

            "address.complement.string" => "validation.address.complement.string",

            "address.neighborhood.required" => "validation.address.neighborhood.required",
            "addres.neighborhood.string" => "validation.address.neighborhood.string",

            "address.city.required" => "validation.address.city.required",
            "address.city.string" => "validation.address.city.string",

            "address.state.required" => "validation.address.state.required",
            "address.state.string" => "validation.address.state.string"
        ];
    }
}
