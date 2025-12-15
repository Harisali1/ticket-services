<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgencyStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'agency_name'       => ['required', 'string', 'max:255'],
            'piv'               => ['required', 'string', 'max:50'],
            'agency_address'    => ['required', 'string', 'max:500'],

            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255'],
            'phone_no'          => ['required', 'digits_between:11,15'],

            'password'          => ['required', 'string', 'min:6'],
            'confirm_password'  => ['required', 'same:password'],

            'status'            => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'agency_name.required'      => 'Agency name is required',
            'piv.required'              => 'P.IVA is required',
            'agency_address.required'   => 'Agency address is required',

            'name.required'             => 'Name is required',
            'email.required'            => 'Email is required',
            'email.email'               => 'Invalid email format',

            'phone_no.required'         => 'Phone number is required',
            'phone_no.digits_between'   => 'Phone must be at least 11 digits',

            'password.required'         => 'Password is required',
            'password.min'              => 'Password must be at least 6 characters',

            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same'     => 'Passwords do not match',

            'status.required'           => 'Status is required',
        ];
    }
}
