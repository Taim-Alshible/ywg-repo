<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiaryRequest extends FormRequest
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
            'fName' => 'required | string | max:40',
            'father_name' => 'required | string | max:40',
            'lName' => 'required | string | max:40',
            'phone' => 'required | string | min:10',
            'nationalNum' => 'nullable | string ',
            'age' => 'required | integer',
            'location' => 'required | string | max:40',
            'numOfPeople' => 'required | integer',
            'size' => 'nullable | string',
            'delivered' => 'boolean'
        ];
    }
}
