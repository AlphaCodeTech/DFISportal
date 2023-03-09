<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use App\Models\Applicant;
use App\Services\SMSService;
use App\Http\Requests\AdmissionRequest;

class AdmissionController extends Controller
{
    public function __construct(private SMSService $smsservice)
    {
    }

    public function store(AdmissionRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('student');
        }

        if ($request->hasFile('birth_certificate')) {
            $birthPath = $request->file('birth_certificate')->store('student');
        }

        if ($request->hasFile('immunization_card')) {
            $cardPath = $request->file('immunization_card')->store('student');
        }

        $applicant = Applicant::firstOrCreate([
            "surname" => $validated['surname'],
            "middlename" => $validated['middlename'],
            "lastname" => $validated['lastname'],
            "gender" => $validated['gender'],
            "blood_group" => $validated['blood_group'],
            "genotype" => $validated['genotype'],
            "allergies" => $validated['allergies'],
            "disabilities" => $validated['disabilities'],
            "prevSchool" => $validated['prevSchool'],
            "reason" => $validated['reason'],
            "introducer" => $validated['introducer'],
            "driver" => $validated['driver'],
            "dob" => $validated['dob'],
            "guardian_id" => $validated['guardian_id'],
            "class_id" => $validated['class_id'],
            "photo" => $photoPath,
            "birth_certificate" => $birthPath,
            "immunization_card" => $cardPath,
        ]);

        if ($applicant) {
            $phone = $validated['phone'];

            $message = "Your application is successfully,\n
                        please kindly wait for us as we review it";

            $response = $this->smsservice->sendSMS($phone, $message);
            
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

            toast('Application completed successfully', 'success');
            return redirect()->route('home.index');
        } else {
            toast('Error submitting your application form', 'error');
            return redirect()->back();
        }
    }
}
