<?php

namespace App\Http\Requests\Section;

use App\Models\Section;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSectionRequest extends FormRequest
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
            'name' => ['required', 'unique:' . Section::class],
            'description' => ['required', 'max:255'],
            'display_order' => ['required', 'integer'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
