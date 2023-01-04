<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Carbon;
use App\Http\Requests\AdmissionRequest;

class AdmissionController extends Controller
{
    public function store(AdmissionRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('student');
        }
        if ($request->hasFile('birth_certificate')) {
            $birthPath = $request->file('birth_certificate')->store('student');
        }
        if ($request->hasFile('immunization_card')) {
            $cardPath = $request->file('immunization_card')->store('student');
        }

        $student = Student::create([
            "surname" => $validated['surname'],
            "middlename" => $validated['middlename'],
            "lastname" => $validated['lastname'],
            "gender" => $validated['gender'],
            "blood_group" => $validated['blood_group'],
            "genotype" => $validated['genotype'],
            "allergies" => $validated['allergies'],
            "disabilities" => $validated['disabilities'],
            "prevSchool" => $validated['prevSchool'],
            "reason" => $validated['reason'],
            "introducer" => $validated['introducer'],
            "driver" => $validated['driver'],
            "status" => false,
            "dob" => $validated['dob'],
            "parent_id" => $validated['parent_id'],
            "class_id" => $validated['class_id'],
            "photo" => $photoPath,
            "birth_certificate" => $birthPath,
            "immunization_card" => $cardPath,
            "admission_date" => Carbon::now(),
        ]);

        if ($student) {
            toast('Admission form purchased successfully', 'success');
            return redirect()->route('home.index');
        } else {
            toast('Error Purchasing admission form', 'error');
            return redirect()->back();
        }
    }
}
