<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function showfees()
    {
        return view('frontend.payfees');
    }

    public function payfees(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'total_fees' => 'required',
            'amount_paid' => 'required',
            'amount_unpaid' => 'required',
            'term_id' => 'required',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'sandbox_sk_06fda0d87d3772b8c6e8cccd5b6e030f7707f3baf944',
        ])->post('https://sandbox-api-d.squadco.com/transaction/initiate', [
            'email' => $request->email,
            'amount' => intval($request->amount_paid),
            'initiate_type' => 'inline',
            'currency' => 'NGN',
            'customer_name' => $request->customer_name,
            'callback_url' => route('fees.verify'),
        ]);

        if ($response['status'] == 200) {
            $data = $response->json();
            $url = $data['data']['checkout_url'];

            $finance = new Finance();
            $finance->student_id = $request->student_id;
            $finance->total_fees = $request->total_fees;
            $finance->amount_paid = $request->amount_paid;
            $finance->amount_unpaid = $request->amount_unpaid;
            $finance->term_id = $request->term_id;
            $finance->status = false;
            $finance->transaction_ref = $data['data']['transaction_ref'];
            $finance->save();

            return redirect($url);
        } else {
            $data = $response->json();
            alert('Error', $data['message'], 'error');

            return redirect()->back();
        }
    }

    public function verifyFees(Request $request)
    {
        $transaction_ref = $request->get('reference');

        return view('frontend.verify');
    }

    public function verify(Request $request)
    {
        $finance = Finance::where('transaction_ref', $request->ref)->where('status', false)->first();
        if ($finance) {
            $finance->status = true;
            $finance->update();
            alert('Congratulations', 'School Fees Verifification was successful', 'success');
        return redirect()->route('home.index');
        }else{
            alert('Sorry', 'School Fees Verifification already done contact the management for more support', 'success');
        return redirect()->route('home.index');
        }
        
    }
}
