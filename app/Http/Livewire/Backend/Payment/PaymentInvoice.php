<?php

namespace App\Http\Livewire\Backend\Payment;

use App\Helpers\QS;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Repositories\PaymentRepository;
use App\Repositories\StudentRepository;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentInvoice extends Component
{
    public $studentRecord;
    public $uncleared;
    public $cleared;
    public $state = [];
    public bool $isComplete = false;
    public bool $isIncomplete = true;
    public $year;
    public $toBeReset = null;

    protected $listeners = ['delete' => 'reset_record', 'refreshComponent' => '$refresh'];

    public function mount(PaymentRepository $paymentRepository, StudentRepository $studentRepository, $student_id, $year = null)
    {
        $this->year = QS::getCurrentSession();

        if (!$student_id) {
            $this->dispatchBrowserEvent('show-confirm', ['message' => __('msg.rnf'), 'type' => 'error']);
        }

        $invoice = $year ? $paymentRepository->getAllMyPR($student_id, $year) : $paymentRepository->getAllMyPR($student_id);

        $this->studentRecord = $studentRepository->findByUserId($student_id)->first();

        $payment_record = $invoice->get();

        $this->uncleared = $payment_record->where('paid', 0);
        $this->cleared = $payment_record->where('paid', 1);
    }


    public function render()
    {
        return view('livewire.backend.payment.payment-invoice')->layout('backend.layouts.app');
    }

    public function fetchUncleared()
    {
        $this->isComplete = false;
        $this->isIncomplete = true;
    }

    public function fetchCleared()
    {
        $this->isComplete = true;
        $this->isIncomplete = false;
    }

    public function pay_now($id)
    {
        $paymentRepository = App::make(PaymentRepository::class);

        $validated = Validator::make($this->state, [
            'amount_paid' => 'required|numeric'
        ], [], ['amount_paid' => 'Amount Paid'])->validate();

        $payment_record = $paymentRepository->findRecord($id);

        $payment = $paymentRepository->find($payment_record->payment_id);
        $data['amount_paid'] = $amount_paid = $payment_record->amount_paid + $validated['amount_paid'];
        $data['balance'] = $balance = $payment->getRawOriginal('amount') - $amount_paid;
        $data['paid'] = $balance < 1 ? 1 : 0;

        $paymentRepository->updateRecord($id, $data);

        $data2['amount_paid'] = $validated['amount_paid'];
        $data2['balance'] = $balance;
        $data2['pr_id'] = $id;
        $data2['year'] = $this->year;

        $paymentRepository->createReceipt($data2);

        $this->state = [];

        $this->dispatchBrowserEvent('show-confirm', ['message' => __('msg.update_ok')]);
        $this->emit('refreshComponent');
    }

    public function confirmReset($id)
    {
        $this->toBeReset = $id;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to reset this Payment?']);
    }

    public function reset_record()
    {
        $paymentRepository = App::make(PaymentRepository::class);

        $payment_record['amount_paid'] = $payment_record['paid'] = $payment_record['balance'] = 0;

        $paymentRepository->updateRecord($this->toBeReset, $payment_record);

        $paymentRepository->deleteReceipts(['pr_id' => $this->toBeReset]);

        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Payment reset successfully!']);
        $this->emit('refreshComponent');

    }

    
}
