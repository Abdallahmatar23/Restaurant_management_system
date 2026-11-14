<?php

namespace App\Http\Requests\Subcategory;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubcategoryRequest extends FormRequest
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
            'name' => ['required','string' , 'max:255', Rule::unique('subcategories', 'name')->ignore($this->route('subcategory'))],
            'description' => ['required','string'],
            'category_id' => ['required','exists:categories,id'],
            'display_order' => ['required','integer','min:1'],
            'status' => ['required',Rule::in(['active','inactive'])],
        ];
    }
}
