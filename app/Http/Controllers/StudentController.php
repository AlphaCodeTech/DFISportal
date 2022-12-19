<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\Student;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return view('backend.students.index',compact('students'));
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
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('student');
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
            "address" => $validated['address'],
            "photo" => $path
        ]);
        if ($student) {
            toast('Student created successfully','success');
            return redirect()->route('student.index');
            
        }else{
            toast('Student not created','error');
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

        return view('backend.students.edit',compact('student'));
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
        $student->address = $validated['address'];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('student');
            $student->photo = $path;
        }
        
        $student->save();

        toast('Student updated successfully','success');
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
        //
    }
}
