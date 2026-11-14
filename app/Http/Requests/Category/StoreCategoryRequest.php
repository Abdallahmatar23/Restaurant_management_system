<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use App\Models\Section;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'unique:' . Category::class],
            'description' => ['required', 'min:3'],
            'display_order' => ['required', 'integer', 'min:1'],
            'section_id' => ['required', 'exists:sections,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])]
        ];
    }
}
