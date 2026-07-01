<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TownshipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Auto-generate slug from name before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->name) {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'builder_id' => 'required|exists:builders,id',
            'name'       => 'required|string|min:3|max:255',
            'slug'       => 'required|string',
            'location'   => 'required|string|max:255',
            'description'=> 'nullable|string',
            'rera_no'    => 'nullable|string|max:50',
            'status'     => 'required|boolean',
        ];
    }
}
