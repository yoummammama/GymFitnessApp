<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'gym_id' => [
                'required',
                'exists:gyms,id',
                'integer',
            ],
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
                'date_format:Y-m-d',
            ],
            'time_slot' => [
                'required',
                'string',
                Rule::in([
                    '8:00 AM - 10:00 AM',
                    '10:00 AM - 12:00 PM',
                    '12:00 PM - 2:00 PM',
                    '2:00 PM - 4:00 PM',
                    '4:00 PM - 6:00 PM',
                ]),
            ],
        ];
    }

    /**
     * Get custom error messages for validator rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'gym_id.required' => 'Please select a gym to update.',
            'gym_id.exists' => 'The selected gym does not exist.',
            'booking_date.required' => 'Please select a new booking date.',
            'booking_date.date' => 'The booking date must be a valid date.',
            'booking_date.after_or_equal' => 'The booking date must be today or in the future.',
            'time_slot.required' => 'Please select a time slot for this booking.',
            'time_slot.in' => 'The selected time slot is invalid.',
        ];
    }
}
