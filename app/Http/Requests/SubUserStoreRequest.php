<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubUserStoreRequest extends FormRequest
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
        return [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:subusers,email',
            'phone'       => 'required|digits:10',
            'password'    => 'required|min:6|confirmed',
            // 'designation' => 'required|string|max:255',
            // 'role'        => 'required|string',
            // 'status'      => 'required|in:active,inactive',
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
