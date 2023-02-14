<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class MarkSelector extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:class_sections,id',
            'subject_id' => 'required|exists:subjects,id',
        ];
    }

    public function attributes()
    {
        return  [
            'exam_id' => 'Exam',
            'class_id' => 'Class',
            'section_id' => 'Section',
            'subject_id' => 'Subject',
        ];
    }
}
