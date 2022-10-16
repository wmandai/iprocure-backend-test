<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAdderRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'category' => 'required',
            'quantity' => 'required|integer|gt:0',
            'unit_cost' => 'required|numeric|gt:0',
            'manufacturer' => 'required',
            'distributor' => 'required',
        ];
    }
}
