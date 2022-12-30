<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassStoreRequest;
use App\Http\Requests\ClassUpdateRequest;
use App\Models\Clazz;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Clazz::all();

        return view('backend.classes.index',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassStoreRequest $request)
    {
        $data = $request->validated();
        
        $save = Clazz::create($data);

        if($save){
            toast('Class Created Successfully','success');
            return redirect()->route('class.index');
        }else{
            toast('Class Creation Failed','error');
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
        $class = Clazz::find($id);
        return view('backend.classes.edit',compact('class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $class = Clazz::find($id);
        $save = $class->update($data);

        if($save){
            toast('Class Updated Successfully','success');
            return redirect()->route('class.index');
        }else{
            toast('Class Update Failed','error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Clazz::find($id);
        $delete = $class->delete();

        if($delete){
            toast('Class Deleted Successfully','success');
            return redirect()->route('class.index');
        }else{
            toast('Class Deletion Failed','error');
            return redirect()->back();
        }
    }

    public function assignSubjectCreate()
    {
        return view('backend.classes.assignSubject');
    }

    public function assignSubject(Request $request)
    {
        $id = $request->class_id;

        $class = Clazz::find($id);
        $class->subjects()->sync($request->subject_id);
        toast("Subjects assigned to class successfully",'success');
        return redirect()->route('class.index');
    }
}
