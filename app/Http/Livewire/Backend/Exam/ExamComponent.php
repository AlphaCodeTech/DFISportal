<?php

namespace App\Http\Livewire\Backend\Exam;

use App\Models\Exam;
use App\Models\Term;
use App\Models\Session;
use App\Repositories\ExamRepository;
use App\Settings\AcademicSetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ExamComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public Exam $exam;
    public $terms;
    public $selectedExam = null;
    public $sessions;

    public function mount(AcademicSetting $setting)
    {
        $this->terms = Term::whereHas('session', function ($query) use ($setting) {
            $query->where('name', $setting->current_session);
        })->get();

        $this->sessions = Session::all();
    }

    protected $listeners = ['delete' => 'destroy'];

    public function render(ExamRepository $examRepository)
    {
        $exams = $examRepository->all();
        return view('livewire.backend.exam.exam-component', compact('exams'))->layout('backend.layouts.app');
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'term_id' => 'required|integer|exists:terms,id',
            'start_date'  => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ], ['term_id' => 'the term field is required'])->validate();

        $examRepository->create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Exam created successfully!']);
    }

    public function edit(Exam $exam)
    {
        $this->exam = $exam;

        $this->isEditing = true;
        $this->state = $exam->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update(ExamRepository $examRepository)
    {

        $data =  Validator::make($this->state, [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'term_id' => 'required|integer|exists:terms,id',
            'start_date'  => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ], ['term_id' => 'the term field is required'])->validate();

        $examRepository->update($this->exam->id, $data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Exam updated successfully!']);
    }

    public function show(Exam $exam)
    {
        $this->selectedExam = $exam;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($id)
    {
        $this->toBeDeleted = $id;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this exam?']);
    }

    public function destroy(ExamRepository $examRepository)
    {
        $examRepository->delete($this->toBeDeleted);

        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Exam deleted successfully!']);
    }
}
