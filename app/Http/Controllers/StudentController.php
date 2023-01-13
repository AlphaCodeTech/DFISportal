<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StudentRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Requests\PromoteStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('Teacher')) {
            $teacher = auth()->user();
            $students = $teacher->students;
            return view('backend.students.index', compact('students'));
            
        } else {
            $students = Student::with(['parent', 'class'])
                ->where('admitted', true)

                ->latest()
                ->get();
                return view('backend.students.index', compact('students'));
        }
        // $students = Student::with(['parent', 'class'])->where('admitted', true)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $validated = $request->validated();
        $birthPath = null;
        $cardPath = null;

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
            "status" => $validated['status'],
            "dob" => $validated['dob'],
            "admission_date" => $validated['admission_date'],
            "parent_id" => $validated['parent_id'],
            "class_id" => $validated['class_id'],
            "photo" => $photoPath,
            "blood_group" => $validated['blood_group'],
            "genotype" => $validated['genotype'],
            "allergies" => $validated['allergies'],
            "disabilities" => $validated['disabilities'],
            "prevSchool" => $validated['prevSchool'],
            "reason" => $validated['reason'],
            "introducer" => $validated['introducer'],
            "driver" => $validated['driver'],
            "status" => $validated['status'],
            'admitted' => true,
            "birth_certificate" => $birthPath,
            "immunization_card" => $cardPath,
        ]);

        if ($student) {
            toast('Student created successfully', 'success');
            return redirect()->route('student.index');
        } else {
            toast('Student not created', 'error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);

        return view('backend.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $student = Student::find($id);

        $student->surname = $validated['surname'];
        $student->middlename = $validated['middlename'];
        $student->lastname = $validated['lastname'];
        $student->gender = $validated['gender'];
        $student->status = $validated['status'];
        $student->dob = $validated['dob'];
        $student->admission_date = $validated['admission_date'];
        $student->parent_id = $validated['parent_id'];
        $student->class_id = $validated['class_id'];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('student');
            $student->photo = $path;
        }

        $student->save();

        toast('Student updated successfully', 'success');
        return redirect()->route('student.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        Storage::disk('student')->delete($student->photo);

        $student->delete();
        toast('Student deleted successfully', 'success');
        return redirect()->back();
    }

    public function promote(PromoteStudentRequest $request, $id)
    {
        $data = $request->validated();

        $student = Student::find($id);
        $student->class_id = $data['new_class_id'];
        $student->save();

        toast('Student promoted successfully', 'success');
        return redirect()->route('student.index');
    }

    public function ShowPromotionForm($id)
    {
        $student = Student::find($id);
        return view('backend.students.promote', compact('student'));
    }
}
