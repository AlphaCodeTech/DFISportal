<?php

namespace App\Http\Controllers\Backend\Payment;

use App\Helpers\QS;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Repositories\ClassRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentController extends Controller
{
    protected $classRepository, $paymentRepository, $studentRepository, $year;

    public function __construct(ClassRepository $classRepository, PaymentRepository $paymentRepository, StudentRepository $studentRepository)
    {
        $this->classRepository = $classRepository;
        $this->paymentRepository = $paymentRepository;
        $this->year = Qs::getCurrentSession();
        $this->studentRepository = $studentRepository;

        $this->middleware('teamAccount');
    }

    public function receipts($id)
    {
        if (!$id) {
            return QS::goWithDanger();
        }

        try {
            $data['payment_record'] = $payment_record = $this->paymentRepository->getRecord(['id' => $id])->with('receipt')->first();
        } catch (ModelNotFoundException $ex) {
            return back();
            toast(__('msg.rnf'), 'error');
        }
        $data['receipts'] = $payment_record->receipt;
        $data['payment'] = $payment_record->payment;
        $data['student_record'] = $this->studentRepository->findByUserId($payment_record->student_id)->first();

        return view('backend.receipt', $data);
    }

    public function pdf_receipts($id)
    {
        if (!$id) {
            return Qs::goWithDanger();
        }

        try {
            $data['payment_record'] = $payment_record = $this->paymentRepository->getRecord(['id' => $id])->with('receipt')->first();
        } catch (ModelNotFoundException $ex) {
            return back();
            toast(__('msg.rnf'), 'success');
        }
        $data['receipts'] = $payment_record->receipt;
        $data['payment'] = $payment_record->payment;
        $data['student_record'] = $student_record = $this->studentRepository->findByUserId($payment_record->student_id)->first();


        $pdf_name = 'Receipt_' . $payment_record->ref_no . '.pdf';

        return PDF::loadView('backend.PDFreceipt', $data)->download($pdf_name);

        //return $this->downloadReceipt('pages.support_team.payments.receipt', $data, $pdf_name);
    }

    protected function downloadReceipt($page, $data, $name = NULL)
    {
        $path = 'receipts/file.html';
        $disk = Storage::disk('local');
        $disk->put($path, view($page, $data));
        $html = $disk->get($path);
        return PDF::loadHTML($html)->download($name);
    }
}
