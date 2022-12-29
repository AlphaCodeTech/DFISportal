<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\TermType;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::with(['session', 'term_type'])->get();

        return view('backend.terms.index',compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'term_type_id' => 'required|exists:term_types,id',
        ]);

        $term = Term::create([
            'term_type_id' => $request->term_type_id,
            'session_id' => $request->session_id,
        ]);

        if ($term) {
            toast('Term created successfully', 'success');
            return redirect()->route('term.index');
        }else {
            toast('Term not created successfully', 'error');
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
        $term = Term::find($id);
        return view('backend.terms.edit', compact('term'));
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
            'session_id' => 'required|exists:sessions,id',
            'term_type_id' => 'required|exists:term_types,id',
        ]);

        $term  =Term::find($id);

        $term->session_id = $request->session_id;
        $term->term_type_id = $request->term_type_id;

        $term->save();

        toast('Term updated successfully', 'success');
        return redirect()->route('term.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $term = Term::find($id);

        $term->delete();

        toast('Term deleted successfully','success');
        return redirect()->back();
    }

    public function createTermType()
    {
        return view('backend.terms.create_termtype');
    }

    public function storeTermType(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $termType = TermType::create([
            'name' => $request->name
        ]);

        if ($termType)
        {
            toast('Term Type created successfully', 'success');
            return  redirect()->route('term.index');
        }else{
            toast('Unable to create term type', 'error');
            return redirect()->back();
        }
    }
}
