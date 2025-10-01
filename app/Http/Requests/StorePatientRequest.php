<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fName' => 'required | string',
            'father_name' => 'required | string',
            'lName' => 'required | string',
            'phone' => 'required | string',
            'location' => 'required | string',
            'age' => 'required | integer',
            'needDoctor' => 'boolean',
            'specialty' => 'nullable | string'
        ];
    }
}
