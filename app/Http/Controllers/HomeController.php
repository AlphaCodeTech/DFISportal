<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function purchase()
    {
        return view('frontend.purchase');
    }

    public function showfees()
    {
        return view('frontend.payfees');
    }

    public function payfees(Request $request)
    {
        dd($request->all());
        $request->validate([
            'student_id' => 'required',
            'total_fees' => 'required',
            'amount_paid' => 'required',
            'amount_unpaid' => 'required',
            'term_id' => 'required',
            'status' => 'required',
            'transaction_ref' => 'required',
        ]);

        $finance = new Finance();
        $finance->student_id = $request->student_id;
        $finance->total_fees = $request->total_fees;
        $finance->amount_paid = $request->amount_paid;
        $finance->amount_unpaid = $request->amount_unpaid;
        $finance->term_id = $request->term_id;
        $finance->status = $request->status;
        $finance->transaction_ref = $request->transaction_ref;
        $finance->save();

        return redirect()->route('fees.pay')->with('success', 'Fees paid successfully');
    
        
    }
}
