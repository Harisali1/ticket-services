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
            'pnr_no'         => ['required', 'string', 'max:255'],
            'airline_id'     => ['required', 'integer', 'exists:air_lines,id'],
            'seats'          => ['required', 'integer', 'min:1'],
            'departure_date' => ['required', 'date'],
            'departure_time' => ['required', 'date_format:H:i'],
            'arrival_date'   => ['required', 'date', 'after_or_equal:departure_date'],
            'arrival_time'   => ['required', 'date_format:H:i'],
            'pnr_file'       => ['required', 'file', 'mimes:png,jpg,jpeg', 'max:5120'], // 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'pnr_no.required'         => 'PNR number is required.',
            'pnr_no.max'              => 'PNR number cannot exceed 255 characters.',

            'airline_id.required'     => 'Please select an airline.',
            'airline_id.exists'       => 'Selected airline is invalid.',

            'seats.required'          => 'Seats field is required.',
            'seats.integer'           => 'Seats must be a number.',
            'seats.min'               => 'Seats must be at least 1.',

            'departure_date.required' => 'Departure date is required.',
            'departure_date.date'     => 'Invalid departure date.',

            'departure_time.required' => 'Departure time is required.',
            'departure_time.date_format' => 'Departure time format must be HH:MM.',

            'arrival_date.required'   => 'Arrival date is required.',
            'arrival_date.date'       => 'Invalid arrival date.',
            'arrival_date.after_or_equal' => 'Arrival date cannot be before departure date.',

            'arrival_time.required'   => 'Arrival time is required.',
            'arrival_time.date_format'=> 'Arrival time format must be HH:MM.',

            'pnr_file.required'       => 'PNR document is required.',
            'pnr_file.mimes'          => 'Only JPG, PNG, or JPEG files are allowed.',
            'pnr_file.max'            => 'PNR document must not exceed 5MB.',
        ];
    }
}
