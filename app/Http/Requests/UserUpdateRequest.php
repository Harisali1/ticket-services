<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        dd($this->user);
        return [
            'name'     => ['required', 'string', 'max:255'],

            'email'    => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->email)
            ],

            'phone_no' => ['required', 'digits_between:10,15'],

            // Password OPTIONAL on update
            'password' => ['nullable', 'string', 'min:6'],

            'confirm_password' => [
                'nullable',
                'same:password'
            ],

            'status'   => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'               => 'Name is required',

            'email.required'              => 'Email is required',
            'email.email'                 => 'Invalid email format',
            'email.unique'                => 'Email already exists',

            'phone_no.required'           => 'Phone number is required',
            'phone_no.digits_between'     => 'Phone must be between 10 and 15 digits',

            'password.min'                => 'Password must be at least 6 characters',

            'confirm_password.same'       => 'Passwords do not match',

            'status.required'             => 'Status is required',
        ];
    }
}
