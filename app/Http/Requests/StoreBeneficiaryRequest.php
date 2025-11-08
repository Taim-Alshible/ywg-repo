<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'fName' => [
                'required',
                'string',
                'max:40',
            ],
            'father_name' => 'required | string | max:40',
            'lName' => [
                'required',
                'string',
                'max:40',
                Rule::unique('beneficiaries')->where(function ($query) {
                    return $query
                        ->where('fName', $this->input('fName'))
                        ->where('father_name', $this->input('father_name'))
                        ->where('lName', $this->input('lName'));
                }),
            ],
            'phone' => 'required | string | min:10',
            'nationalNum' => 'nullable | string ',
            'age' => 'required | integer',
            'location' => 'required | string | max:40',
            'numOfPeople' => 'required | integer',
            'size' => 'nullable | string',
            'checked' => 'boolean',
            'delivered' => 'boolean'
        ];
    }
}
