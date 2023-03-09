<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFormFee;
use App\Models\User;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(User $user)
    {
        return view('frontend.index');
    }

    public function purchase(Guardian $guardian)
    {
        $guardian_id = $guardian->id;
        $phone = $guardian->phone;

        return view('frontend.purchase', compact('guardian_id', 'phone'));
    }

    public function guardianCreate()
    {
        return view('frontend.guardian');
    }

    public function guardianStore(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => 'required|email|unique:guardians,email',
            'phone' => 'required|digits:13|unique:guardians,phone',
            'residential_address' => 'required',
            'state' => 'required',
            'lga' => 'required|string',
            'religion' => 'required',
            'nationality' => 'required',
            'occupation' => 'required|string',
            'business_address' => 'required',
            'relationship' => 'required',
            'family_history' => 'required',
            'id_card' => 'required|file|mimes:pdf,doc|max:5048',
        ], [
            'lga.required' => 'The local government area field is required',
            'lga.string' => 'The Local Government Area field is must be a string',
        ])->validate();

        $path = $request->file('id_card')->store('parent');

        $guardian = Guardian::firstOrCreate([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'residential_address' => $data['residential_address'],
            'state' => $data['state'],
            'lga' => $data['lga'],
            'password' => Hash::make($data['phone']),
            'religion' => $data['religion'],
            'nationality' => $data['nationality'],
            'occupation' => $data['occupation'],
            'business_address' => $data['business_address'],
            'relationship' => $data['relationship'],
            'family_history' => $data['family_history'],
            'id_card' => $path,
        ]);
        return redirect()->route('form.fee.create', ['guardian' => $guardian]);
    }

    public function continue(Request $request)
    {
        $formFee = AdmissionFormFee::where('transaction_ref', $request->transaction_ref)
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
