<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'isActive' => 'bool|required',
            'name' => 'required|string',
            'price' => 'required|decimal',
            'quantity' => 'required|numeric',
            'category_id' => 'required|numeric',
            'category.name' => 'required',
            'category.password' => 'required',
            'category.email' => 'required|email',
            'item' => 'array:name, id, password',
            'item.*.name' => 'string|required|',
        ];
    }


}
