<?php

namespace App\Http\Livewire\Backend\Settings;

use App\Repositories\ClassRepository;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\Validator;

class AcademicComponent extends Component
{
    use WithFileUploads;

    public $state = [];
    public $classLevels;

    public function mount(AcademicSetting $setting, ClassRepository $classRepository)
    {
        $this->state = $setting->toArray();
        $this->classLevels = $classRepository->getLevels();
        // dd($this->state);
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
            'lock_exam' => 'required',
        ])->validate();



        $academicSetting->term_begins = $data['term_begins'];
        $academicSetting->term_ends = $data['term_ends'];
        $academicSetting->current_session = $data['current_session'];
        $academicSetting->lock_exam = $data['lock_exam'];

        $academicSetting->save();

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Academic Setting Updated Successfully!']);
    }
}
