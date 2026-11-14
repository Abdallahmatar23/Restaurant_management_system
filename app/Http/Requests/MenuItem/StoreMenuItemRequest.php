<?php

namespace App\Http\Requests\MenuItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuItemRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:200'],
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['required', 'max:2048', 'mimes:jpg,jpeg,png'],
            'preparation_time' => ['nullable', 'integer', 'min:0'],
            'availability' => ['required', Rule::in(['available', 'unavailable'])],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', Rule::in([
                'Vegetarian',
                'Vegan',
                'Spicy',
                "Chef's Special",
                'Popular',
            ])],
        ];
    }
}
