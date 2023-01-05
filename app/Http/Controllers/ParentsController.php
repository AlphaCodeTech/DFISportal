<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = Parents::all();

        return view('backend.parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.parents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:parents,email',
            'phone' => 'required',
            'residential_address' => 'required',
            'state' => 'required',
            'lga' => 'required',
            'religion' => 'required',
            'nationality' => 'required',
            'occupation' => 'required',
            'business_address' => 'required',
            'relationship' => 'required',
            'family_history' => 'required',
        ]);

        $parent = Parents::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'residential_address' => $data['residential_address'],
            'state' => $data['state'],
            'lga' => $data['lga'],
            'religion' => $data['religion'],
            'nationality' => $data['nationality'],
            'occupation' => $data['occupation'],
            'business_address' => $data['business_address'],
            'relationship' => $data['relationship'],
            'family_history' => $data['family_history'],
            'password' => Hash::make($data['phone']),
        ]);

        if ($parent) {
            toast('Guardian Created Successfully', 'success');

            return redirect()->route('parent.index');
        } else {
            toast('Error Creating Guardian', 'error');

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
        $parent = Parents::find($id);

        return view('backend.parents.edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            // 'email' => 'required|email|unique:parents,email',
            'phone' => 'required',
            'residential_address' => 'required',
            'state' => 'required',
            'lga' => 'required',
            'religion' => 'required',
            'nationality' => 'required',
            'occupation' => 'required',
            'business_address' => 'required',
            'relationship' => 'required',
            'family_history' => 'required',
        ]);

        $parent = Parents::find($id);

        $parent->name = $request->name;
        $parent->email = $request->email;
        $parent->phone = $request->phone;
        $parent->residential_address = $request->residential_address;
        $parent->state = $request->state;
        $parent->lga = $request->lga;
        $parent->religion = $request->lga;
        $parent->nationality = $request->nationality;
        $parent->occupation = $request->occupation;
        $parent->business_address = $request->business_address;
        $parent->relationship = $request->relationship;
        $parent->family_history = $request->family_history;

        $parent->save();

        toast('Guardian Updated Successfully', 'success');

        return redirect()->route('parent.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parent = Parents::find($id);

        $parent->delete();

        toast('Guardian deleted successfully', 'success');

        return redirect()->back();
    }
}
