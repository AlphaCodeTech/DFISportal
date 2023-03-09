<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "surname" => 'required',
            "middlename" => 'required',
            "lastname" => 'required',
            "gender" => 'required|in:male,female',
            "dob" => 'required|date',
            "blood_group" => 'required',
            "genotype" => 'required',
            "allergies" => 'required',
            "disabilities" => 'required',
            "prevSchool" => 'required',
            "reason" => 'required',
            "introducer" => 'required',
            "driver" => 'required',
            'phone' => 'required',
            "guardian_id" => 'required|exists:guardians,id',
            "class_id" => 'required|exists:classes,id',
            "photo" => 'required|file|mimes:jpg,png,jpeg',
            "birth_certificate" => 'required|file|mimes:jpg,png,jpeg,pdf',
            "immunization_card" => 'required|file|mimes:jpg,png,jpeg,pdf'
        ];
    }

    public function messages()
    {
        return [
            'class_id.required' => 'The class is required',
            'guardian_id.required' => 'The guardian is required',
            'prevSchool.required' => 'The previous school is required',
        ];
    }
}
