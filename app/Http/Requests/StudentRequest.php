<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return dd(auth()->user()->hasPermissionTo('create student'));
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
            'admission_date' => 'required',
            "blood_group" => 'nullable',
            "genotype" => 'nullable',
            "allergies" => 'nullable',
            "disabilities" => 'nullable',
            "prevSchool" => 'nullable',
            "reason" => 'nullable',
            "introducer" => 'nullable',
            "status" => 'nullable',
            "driver" => 'nullable',
            "parent_id" => 'nullable|exists:parents,id',
            "class_id" => 'required|exists:classes,id',
            "photo" => 'required|file|mimes:jpg,png,jpeg',
            "birth_certificate" => 'nullable|file|mimes:jpg,png,jpeg,pdf',
            "immunization_card" => 'nullable|file|mimes:jpg,png,jpeg,pdf'
        ];
    }
}
