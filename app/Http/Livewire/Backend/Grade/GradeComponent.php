<?php

namespace App\Http\Livewire\Backend\Grade;

use App\Models\Exam;
use App\Models\Term;
use App\Models\Grade;
use App\Models\Session;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Settings\AcademicSetting;
use App\Repositories\ExamRepository;
use App\Repositories\ClassRepository;
use Illuminate\Support\Facades\Validator;

class GradeComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public Grade $grade;
    public $levels;
    public $selectedGrade = null;
    public $sessions;

    public function mount(ClassRepository $classRepository)
    {
        $this->levels = $classRepository->getLevels();
        $this->sessions = Session::all();
    }

    protected $listeners = ['delete' => 'destroy'];

    public function render(ExamRepository $examRepository)
    {
        $grades = $examRepository->allGrades();
        return view('livewire.backend.grade.grade-component', compact('grades'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store(ExamRepository $examRepository)
    {
        $data =  Validator::make($this->state, [
            'name' => [
                'required',
                'alpha',
                isset($this->state['level_id']) ? Rule::unique('grades')
                    ->where(
                        fn ($query) => $query
                            ->where([
                                'level_id' => $this->state['level_id']
                            ])
                    ) : ''
            ],
            'mark_from' => 'required|numeric',
            'mark_to' => 'required|numeric|gt:mark_from',
            'level_id' => 'nullable|exists:levels,id',
            'remark' => 'required',
        ], [
            'mark_from.required' => 'the Mark From field is required',
            'mark_to.required' => 'the Mark To field is required',
        ])->validate();

        $data['name'] = Str::upper($data['name']);

        $examRepository->createGrade($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Grade created successfully!']);
    }

    public function edit(Grade $grade)
    {
        $this->grade = $grade;

        $this->isEditing = true;
        $this->state = $grade->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update(ExamRepository $examRepository)
    {

        $data =  Validator::make($this->state, [
            'name' => [
                'required',
                'alpha',
                isset($this->state['level_id']) ? Rule::unique('grades')
                    ->where(
                        fn ($query) => $query
                            ->where([
                                'level_id' => $this->state['level_id']
                            ])
                    )->ignore($this->grade->id) : ''
            ],
            'mark_from' => 'required|numeric',
            'mark_to' => 'required|numeric|gt:mark_from',
            'level_id' => 'nullable|exists:levels,id',
            'remark' => 'required',
        ], [
            'mark_from.required' => 'the Mark From field is required',
            'mark_to.required' => 'the Mark To field is required',
        ])->validate();

        $data['name'] = Str::upper($data['name']);

        $examRepository->updateGrade($this->grade->id, $data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Grade updated successfully!']);
    }

    public function show(Grade $grade)
    {
        $this->selectedGrade = $grade;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($id)
    {
        $this->toBeDeleted = $id;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this grade?']);
    }

    public function destroy(ExamRepository $examRepository)
    {
        $examRepository->deleteGrade($this->toBeDeleted);

        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Exam deleted successfully!']);
    }
}
