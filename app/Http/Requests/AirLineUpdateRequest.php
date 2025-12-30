<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirLineUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'code'       => ['required', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Airline name is required',
            'code.required'      => 'Code is required',
        ];
    }
}
