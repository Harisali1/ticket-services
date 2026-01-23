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
            // 'pnr_type'       => ['required'],
            'departure_id'   => ['required', 'integer', 'exists:airports,id'],
            'arrival_id'     => ['required', 'integer', 'exists:airports,id'],
            'airline_id'     => ['required', 'integer', 'exists:air_lines,id'],
            'baggage'     => ['required'],
            'seats'          => ['required', 'integer', 'min:1'],
            'departure_date' => ['required', 'date'],
            'arrival_date'   => ['required', 'date', 'after_or_equal:departure_date'],
            'base_price'          => ['required', 'integer'], // 5MB
        ];
    }

    public function messages(): array
    {
        return [
            // 'pnr_type.required'         => 'PNR Type is required.',
            'flight_no.required'        => 'Flight No is required',

            'departure_id.required'     => 'Please select an departure.',
            'departure_id.exists'       => 'Selected departure is invalid.',

            'arrival_id.required'     => 'Please select an arrival.',
            'arrival_id.exists'       => 'Selected arrival is invalid.',

            'airline_id.required'     => 'Please select an airline.',
            'airline_id.exists'       => 'Selected airline is invalid.',

            'baggage.required'     => 'Please select at least one baggage.',

            'seats.required'          => 'Seats field is required.',
            'seats.integer'           => 'Seats must be a number.',
            'seats.min'               => 'Seats must be at least 1.',

            'departure_date.required' => 'Departure date is required.',
            'departure_date.date'     => 'Invalid departure date.',

            'arrival_date.required'   => 'Arrival date is required.',
            'arrival_date.date'       => 'Invalid arrival date.',
            'arrival_date.after_or_equal' => 'Arrival date cannot be before departure date.',

            'base_price.required'       => 'Price field is required.',
            'base_price.integer'          => 'Price must be an integer.',
        ];
    }
}
