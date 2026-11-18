<?php

namespace App\Http\Requests\RestaurantTable;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRestaurantTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'table_number' => ['required','unique:restaurant_tables,table_number','alpha_dash'],
            'type' => ['required' , Rule::in(['private','public'])],
            'min_capacity' => ['required','integer','min:1'],
            'max_capacity' => ['required','integer','gte:min_capacity'],
            'area' => ['nullable','string',Rule::in(['ground floor','first floor','garden'])],
            'status' => ['required',Rule::in(['available','occupied','reserved','maintenance'])],
            'notes' => ['nullable','string'],
            // 'unique_token' => ['unique:' . RestaurantTable::class],
        ];
    }
}
