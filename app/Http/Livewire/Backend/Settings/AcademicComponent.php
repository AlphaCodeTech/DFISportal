<?php

namespace App\Http\Livewire\Backend\Settings;

use App\Models\Fee;
use App\Models\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use App\Repositories\ClassRepository;
use Illuminate\Support\Facades\Validator;

class AcademicComponent extends Component
{
    use WithFileUploads;

    public $state = [];
    public $classLevels;
    public $sections;
    public $fees;

    public function mount(AcademicSetting $setting, ClassRepository $classRepository)
    {
        $this->state = $setting->toArray();
        $this->classLevels = $classRepository->getLevels();
        $this->sections = Session::all();
        $this->fees = Fee::orderBy('name','asc')->get();
    }

    public function render()
    {
        return view('livewire.backend.settings.academic-component')->layout('backend.layouts.app');
    }

    public function update(AcademicSetting $academicSetting)
    {
        $data =  Validator::make($this->state, [
            'term_begins' => 'required',
            'term_ends' => 'required',
            'current_session' => 'required',
            'CR_fees' => 'required|integer',
            'NU_fees' => 'required|integer',
            'PR_fees' => 'required|integer',
            'JS_fees' => 'required|integer',
            'SS_fees' => 'required|integer',
            'lock_exam' => 'required|integer',
        ])->validate();



        $academicSetting->term_begins = $data['term_begins'];
        $academicSetting->term_ends = $data['term_ends'];
        $academicSetting->current_session = $data['current_session'];
        $academicSetting->cre_fees = $data['CR_fees'];
        $academicSetting->nur_fees = $data['NU_fees'];
        $academicSetting->pri_fees = $data['PR_fees'];
        $academicSetting->jss_fees = $data['JS_fees'];
        $academicSetting->sss_fees = $data['SS_fees'];
        $academicSetting->lock_exam = $data['lock_exam'];

        $academicSetting->save();

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Academic Setting Updated Successfully!']);
    }
}
