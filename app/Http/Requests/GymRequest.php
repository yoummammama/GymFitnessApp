<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GymRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'campus_location' => [
                'required',
                'string',
                'max:255',
            ],
            'max_capacity' => [
                'required',
                'integer',
                'min:1',
                'max:500',
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
            'name.required' => 'Please enter a gym name.',
            'name.string' => 'The gym name must be a text string.',
            'name.max' => 'The gym name must not exceed 255 characters.',
            'campus_location.required' => 'Please enter a campus location.',
            'campus_location.string' => 'The campus location must be a text string.',
            'campus_location.max' => 'The campus location must not exceed 255 characters.',
            'max_capacity.required' => 'Please enter the maximum capacity.',
            'max_capacity.integer' => 'The maximum capacity must be a whole number.',
            'max_capacity.min' => 'The maximum capacity must be at least 1.',
            'max_capacity.max' => 'The maximum capacity must not exceed 500.',
        ];
    }
}
