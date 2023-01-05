<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fees = Fee::all();
        return view('backend.fees.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.fees.create');
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
            'full_fees' => 'required',
            'part_fees' => 'required',
        ]);

        $fee = Fee::create($data);

        if ($fee) {
            toast('School Fees created Successfully', 'success');

            return redirect()->route('fees.index');
        } else {
            toast('Error creating Fees', 'error');

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
        $fee  = Fee::find($id);

        return view('backend.fees.edit', compact('fee'));
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
        $fee = Fee::find($id);
        $request->validate([
            'full_fees' => 'required',
            'part_fees' => 'required',
        ]);

        $fee->full_fees = $request->full_fees;
        $fee->part_fees = $request->part_fees;

        $fee->save();

        toast('School fees Updated Successfully', 'success');

        return redirect()->route('fees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fee = Fee::find($id);

        $fee->delete();

        toast('School fees Deleted Successfully', 'success');

        return redirect()->route('fees.index');
    }
}
