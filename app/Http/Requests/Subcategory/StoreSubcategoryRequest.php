<?php

namespace App\Http\Requests\Subcategory;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubcategoryRequest extends FormRequest
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
            'name' => ['required','string','unique:' . Subcategory::class],
            'description' => ['required', 'string','min:3'],
            'display_order' => ['required' ,'integer','min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required',Rule::in(['active','inactive'])]
        ];
    }
}
