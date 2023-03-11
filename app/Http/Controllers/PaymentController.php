<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFormFee;
use App\Models\SMS;
use App\Models\Finance;
use App\Models\Guardian;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private $phone;

    public function __construct(public SMSService $smsService)
    {
    }

    public function schoolFeeCreate()
    {
        return view('frontend.fees.payfees');
    }

    public function schoolFeeStore(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'total_fees' => 'required',
            'amount_paid' => 'required',
            'amount_unpaid' => 'required',
            'term_id' => 'required',
        ]);

        $this->phone = str_replace('+', '', $request->phone);

        $response = Http::withHeaders([
            'Authorization' => 'sandbox_sk_06fda0d87d3772b8c6e8cccd5b6e030f7707f3baf944',
        ])->post('https://sandbox-api-d.squadco.com/transaction/initiate', [
            'email' => $request->email,
            'amount' => intval($request->amount_paid) * 100,
            'initiate_type' => 'inline',
            'currency' => 'NGN',
            'customer_name' => $request->customer_name,
            'callback_url' => route('fees.verify', ['phone' => $this->phone]),
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

    public function formFeeCreate(Guardian $guardian)
    {
        return view('frontend.fees.form-fee', compact('guardian'));
    }

    public function formFeeStore(Request $request, Guardian $guardian)
    {
        $data = $request->validate([
            'amount' => 'required',
            'current_session' => 'required',
        ]);

        $key = 'sandbox_sk_06fda0d87d3772b8c6e8cccd5b6e030f7707f3baf944';

        $response = Http::withHeaders([
            'Authorization' => $key,
        ])->post('https://sandbox-api-d.squadco.com/transaction/initiate', [
            'email' => $guardian->email,
            'amount' => intval($request->amount) * 100,
            'initiate_type' => 'inline',
            'currency' => 'NGN',
            'customer_name' => $guardian->name,
            'callback_url' => route('form.purchase', ['guardian' => $guardian->id]),
        ]);

        if ($response['status'] == 200) {
            $data = $response->json();
            $url = $data['data']['checkout_url'];

            $fee = new AdmissionFormFee();
            $fee->buyer_id = $guardian->id;
            $fee->amount = $request->amount;
            $fee->current_session = $request->current_session;
            $fee->transaction_ref = $data['data']['transaction_ref'];
            $fee->save();

            $transaction_ref = $data['data']['transaction_ref'];
            $phone = $guardian->phone;

            $message = "Admission fees payment was successful.\nKindly use this transaction reference to proceed on the application.\n$transaction_ref";

            $response = $this->smsService->sendSMS($phone, $message);

            if ($response['status'] == 'success') {
                SMS::create([
                    'code' => $response['code'],
                    'phone_number' => $response['data']['phone_number'],
                    'reference' => $response['data']['reference'],
                    'errors' => $response['errors'] ?? 'null',
                    'message' => $response['message'],
                    'status' => $response['status'],
                ]);
            }
            
            notify($guardian, 'continue-registration', [
                'url' => route('form.fee.confirm', $transaction_ref),
            ]);

            toast('Form Purchase Successful', 'success');
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
        $phone = request()->segment(2);

        $message = "School fees payment was successful.\nKindly use this transaction reference to verify your payment.\n$transaction_ref";

        $response = $this->smsService->sendSMS($phone, $message);

        $sms = SMS::create([
            'code' => $response['code'],
            'phone_number' => $response['data']['phone_number'],
            'reference' => $response['data']['reference'],
            'errors' => $response['errors'] ?? 'null',
            'message' => $response['message'],
            'status' => $response['status'],
        ]);

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
        } else {
            alert('Sorry', 'School Fees Verifification already done contact the management for more support', 'success');
            return redirect()->route('home.index');
        }
    }

    public function confirmFee($reference)
    {
        $formFee = AdmissionFormFee::where('transaction_ref', $reference)
            ->where('used', false)
            ->first();

        if ($formFee) {
            return redirect()->route('form.purchase', ['guardian' => $formFee->buyer_id]);
        } else {
            alert('Sorry', 'Please Purchase new form, transaction reference not found or already used', 'error');

            return redirect()->route('guardian.create');
        }
    }
}
