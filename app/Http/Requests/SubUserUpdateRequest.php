<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubUserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $subuserId = optional($this->route('subuser'))->id;

        return [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:subusers,email,' . $subuserId,
            'phone'       => 'required|digits:10',
            'password'    => 'nullable|min:6|confirmed',
            'role_id'     => 'nullable' |'exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.digits'       => 'Phone number must be exactly 10 digits.',
            'password.confirmed' => 'Password confirmation does not match.',
            'email.unique'       => 'This email is already registered.',
        ];
    }
}
