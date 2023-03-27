<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;

class PaySchoolFees extends Component
{
    public $student;
    public $studentID;
    public $name;
    public $level;
    public $fullFees;
    public $partFees;
    public $class;
    public $term;
    public $surname;
    public $middlename;
    public $lastname;
    public $amountPaid;
    public $amountUnPaid;
    public $email;
    public $phone;
    public $admno;


    public function render()
    {
        return view('livewire.pay-school-fees');
    }

    protected $rules = [
        'admno' => 'required|exists:students,admno',
    ];

    protected $messages = [
        'admno.required' => 'The Registration Number cannot be empty.',
        'admno.exists' => 'The Registration Number does not exist.',
    ];

    public function updatedAdmno($value)
    {
        $this->validateOnly('admno');
        $academicSetting  = App::make(AcademicSetting::class);

        $this->student = Student::where('admno', $value)->first();

        if ($this->student) {
            $fee = $this->student->level->code . '_fees';

            $this->studentID = $this->student->id;
            $this->name = optional($this->student->guardian)->name;
            $this->level = $this->student->level->name;
            $this->class = $this->student->class->name;
            $this->term = $academicSetting->next_term;
            $this->email = optional($this->student->guardian)->email;
            $this->surname = $this->student->surname;
            $this->middlename = $this->student->middlename;
            $this->lastname = $this->student->lastname;
            $this->fullFees = $academicSetting->$fee;
            $this->partFees = ceil($this->fullFees / 2);
            $this->phone = optional($this->student->guardian)->phone;
        } else {
            $this->level = '';
            $this->class = '';
            $this->term = '';
            $this->email = '';
            $this->surname = '';
            $this->middlename = '';
            $this->lastname = '';
            $this->fullFees = '';
            $this->partFees = '';
            $this->amountPaid = '';
            $this->amountUnPaid = '';
            $this->email = '';
        }
    }

    public function updatedAmountPaid($value)
    {
        $this->amountPaid = $value;
        $this->amountUnPaid = $this->fullFees - $value;
    }
}
