<?php

namespace App\Http\Livewire\Backend\Payment;

use App\Helpers\QS;
use App\Helpers\Pay;
use App\Models\Payment;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Repositories\ClassRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Validator;

class PaymentComponent extends Component
{
    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $selected;
    public $year;
    public $payment;
    public $classes;
    public $selectedPayment;
    public $class_id;
    public bool $filter = false;

    protected $listeners = ['delete' => 'destroy'];

    public function mount(PaymentRepository $paymentRepository, ClassRepository $classRepository, $year = null)
    {
        if ($year) {
            $payment = $paymentRepository->getPayment(['year' => $year])->get();

            if (($payment->count() < 1)) {
                $this->dispatchBrowserEvent('show-confirm', ['message' => __('msg.rnf'), 'type' => 'error']);
            }

            $this->selected = true;
            $this->year = $year;
        } else {
            $this->year = QS::getCurrentSession();
            $this->selected = false;
        }

        $this->classes = $classRepository->all();
    }

    public function render(PaymentRepository $paymentRepository)
    {
        $years = $paymentRepository->getPaymentYears();
        $payments = $this->filter ? $paymentRepository->getPayment(['year' => $this->year])->get()->where('class_id', $this->class_id) : $paymentRepository->getPayment(['year' => $this->year])->get();
        return view('livewire.backend.payment.payment-component', compact('payments', 'years'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $paymentRepository = App::make(PaymentRepository::class);

        $data =  Validator::make($this->state, [
            'title' => 'required|string|min:3',
            'amount' => 'required',
            'class_id' => 'nullable',
            'description' => 'nullable',
            'method' => 'nullable',
        ])->validate();

        $data['year'] = $this->year;
        $data['ref_no'] = Pay::genRefCode();

        $paymentRepository->create($data);


        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Payment created successfully!']);
    }

    public function edit(Payment $payment)
    {
        $this->payment = $payment;
        $this->isEditing = true;
        $this->state = $payment->toArray();
        $this->state['amount'] = $payment->getRawOriginal('amount');
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {
        $paymentRepository = App::make(PaymentRepository::class);

        $data =  Validator::make($this->state, [
            'title' => 'required|string|min:3',
            'amount' => 'required',
            'class_id' => 'nullable',
            'description' => 'nullable',
            'method' => 'nullable',
        ])->validate();

        $paymentRepository->update($this->payment->id, $data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Payment updated successfully!']);
    }


    public function confirmDelete($id)
    {
        $this->toBeDeleted = $id;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this payment?']);
    }

    public function destroy()
    {
        $paymentRepository = App::make(PaymentRepository::class);

        $paymentRepository->find($this->toBeDeleted)->delete();

        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Payment deleted successfully!']);
    }

    public function select_year()
    {
        return redirect()->route('backend.payment', $this->year);
    }

    public function filter($id)
    {
        $this->filter = true;
        $this->class_id = $id;
    }

    public function fetchAll()
    {
        $this->filter = false;
    }
}
