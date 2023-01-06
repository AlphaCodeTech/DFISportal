<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class PaySchoolFees extends Component
{
    public $student;
    public $studentID;
    public $name;
    public $level;
    public $fullFees;
    public $partFees;
    public $class;
    public $surname;
    public $middlename;
    public $lastname;
    public $amountPaid;
    public $amountUnPaid;
    public $email;
    public $phone;


    public function render()
    {
        return view('livewire.pay-school-fees');
    }

    public function fetchDetails($value)
    {
        $this->student = Student::where('admno', $value)->first();
        if ($this->student) {
            $this->studentID = $this->student->id;
            $this->name = $this->student->parent->name;
            $this->level = $this->student->level->name;
            $this->class = $this->student->class->name;
            $this->email = $this->student->parent->email;
            $this->surname = $this->student->surname;
            $this->middlename = $this->student->middlename;
            $this->lastname = $this->student->lastname;
            $this->fullFees = $this->student->level->fee->full_fees;
            $this->partFees = $this->student->level->fee->part_fees;
            $this->phone = $this->student->parent->phone;
        } else {
            $this->level = '';
            $this->class = '';
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

    public function amountPaid($val)
    {
        $this->amountPaid = $val;
        $this->amountUnPaid = $this->fullFees - $val;
    }
}
