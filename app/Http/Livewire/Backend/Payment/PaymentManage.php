<?php

namespace App\Http\Livewire\Backend\Payment;

use App\Helpers\QS;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Repositories\ClassRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Validator;

class PaymentManage extends Component
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

    public function mount(ClassRepository $classRepository, StudentRepository $studentRepository, $class_id = null)
    {
        $this->classes = $classRepository->all();
        $this->year = QS::getCurrentSession();

        if ($class_id) {
            $students = $studentRepository->getRecord(['class_id' => $class_id])->get()->sortBy('name');
            if ($students->count() < 1) {
                $this->dispatchBrowserEvent('show-confirm', ['message' => __('msg.rnf'), 'type' => 'error']);
            }

            $this->selected = true;
            $this->class_id = $class_id;
        }
    }

    public function render(StudentRepository $studentRepository)
    {
        $students = $studentRepository->getRecord(['class_id' => $this->class_id])->get()->sortBy('name');
        
        return view('livewire.backend.payment.payment-manage', compact('students'))->layout('backend.layouts.app');
    }

    public function select_class()
    {
        $paymentRepository = App::make(PaymentRepository::class);
        $studentRepository = App::make(StudentRepository::class);

        $data =  Validator::make($this->state, [
            'class_id' => 'required|exists:classes,id'
        ], [
            'class_id.required' => 'the Class is required',
            'class_id.exists' => 'the Class is does not exist'
        ])->validate();

        $where['class_id'] = $class_id = $data['class_id'];

        $payment1 = $paymentRepository->getPayment(['class_id' => $class_id, 'year' => $this->year])->get();
        $payment2 = $paymentRepository->getGeneralPayment(['year' => $this->year])->get();
        $payments = $payment2->count() ? $payment1->merge($payment2) : $payment1;
        $students = $studentRepository->getRecord($where)->get();

        if ($payments->count() && $students->count()) {
            foreach ($payments as $payment) {
                foreach ($students as $student) {
                    $paymentRecord['student_id'] = $student->id;
                    $paymentRecord['payment_id'] = $payment->id;
                    $paymentRecord['year'] = $this->year;
                    $record = $paymentRepository->createRecord($paymentRecord);
                    $record->ref_no ?: $record->update(['ref_no' => mt_rand(100000, 99999999)]);
                }
            }
        }

        return Qs::goToRoute(['payments.manage', $class_id]);
    }
}
