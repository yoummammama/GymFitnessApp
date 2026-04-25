<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
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
                function ($attribute, $value, $fail) {
                    // If the booking date is today, check if the time slot has already passed
                    if ($value === today()->format('Y-m-d') && $this->input('time_slot')) {
                        $startTime = explode(' - ', $this->input('time_slot'))[0];
                        $timezone = config('app.timezone');
                        $bookingTime = \Carbon\Carbon::createFromFormat('Y-m-d g:i A', $value . ' ' . $startTime, $timezone);
                        $now = \Carbon\Carbon::now($timezone);

                        if ($bookingTime->isPast() || $bookingTime->equalTo($now)) {
                            $fail('The selected booking date and time is in the past. Please choose a future time slot.');
                        }
                    }
                },
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
            'gym_id.required' => 'Please select a gym.',
            'gym_id.exists' => 'The selected gym does not exist.',
            'booking_date.required' => 'Please select a booking date.',
            'booking_date.date' => 'The booking date must be a valid date.',
            'booking_date.after_or_equal' => 'The booking date must be today or in the future.',
            'time_slot.required' => 'Please select a time slot.',
            'time_slot.in' => 'The selected time slot is invalid.',
        ];
    }
}
