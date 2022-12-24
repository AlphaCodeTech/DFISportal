<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required',
            "middlename" => 'required',
            "lastname" => 'required',
            "email" => 'required|email|unique:users',
            "phone" => 'required',
            "gender" => 'required|in:male,female',
            "status" => 'required|in:1,0',
            "dob" => 'required',
            "bank" => 'required',
            "account_name" => "required",
            "account_number" => 'required|min:10',
            "category_id" => 'required|exists:categories,id',
            "level_id" => 'required|exists:levels,id',
            "religion" => 'required',
            "marital_status" => 'required',
            "blood_group" => 'required',
            "nationality" => 'required',
            "qualification" => 'required',
            "address" => 'required',
            "photo" => 'nullable|image|mimes:jpg,png,jpeg',
        ];
    }
}
