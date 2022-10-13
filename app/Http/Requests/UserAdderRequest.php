<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAdderRequest extends FormRequest
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
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'phoneNumber' => 'nullable',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }
}
