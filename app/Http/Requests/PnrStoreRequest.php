<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PnrStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pnr_no'            => ['required', 'string', 'max:255'],
            'airline_id'        => ['required', 'integer', 'max:255'],
            'seats'             => ['required', 'integer'],
            'departure_date'    => ['required', 'string', 'min:6'],
            'departure_time'    => ['required', 'same:password'],
            'arrival_date'      => ['required'],
            'arrival_time'      => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
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
