<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            "status" => 'required|in:active,inactive',
            "dob" => 'required|date',
            "admission_date" => 'required|date',
            "parent_id" => 'required|exists:parents,id',
            "class_id" => 'required|exists:classes,id',
            "address" => 'required',
            "photo" => 'nullable|image|mimes:jpg,png,jpeg'
        ];
    }
}
