<?php

namespace App\Http\Livewire\Backend\Exam;

use App\Http\Requests\Exam\MarkSelector;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;
use App\Repositories\ClassRepository;
use App\Repositories\ExamRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Arr;

class ExamMarkComponent extends Component
{
    use WithFileUploads;

    public $currentClasses;
    public $classes;
    public $currentSections;
    public bool $selected = false;
    public $students;
    public $exams;
    public $subjects;

    public $class_id = null;
    public $subject_id = null;
    public $exam_id = null;
    public $section_id = null;

    public function mount(AcademicSetting $setting, ExamRepository $examRepository, ClassRepository $classRepository,)
    {
        $this->currentClasses = $classRepository->all();
        $this->exams = $examRepository->getExamsByYear(['year' => $setting->current_session]);
        $this->classes = $classRepository->all();
        $this->subjects = collect();
        $this->currentSections = collect();
    }

    public function render()
    {
        return view('livewire.backend.exam.exam-mark')->layout('backend.layouts.app');
    }

    protected function rules()
    {
        $request = new MarkSelector();

        return $request->rules();
    }

    public function updatedClassId($class_id)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->currentSections = $classRepository->getClassSections($class_id);
        $this->subjects = $classRepository->findSubjectByClass($class_id);
        $this->section_id = null;
    }

    public function selector(StudentRepository $studentRepository, ExamRepository $examRepository, AcademicSetting $academicSetting)
    {
        $req = $this->validate();
        $req = collect($req);

        $mark_data = $req->only(['exam_id', 'class_id', 'section_id', 'subject_id'])->toArray();
        $exam_data = $req->only(['exam_id', 'class_id', 'section_id'])->toArray();
        $query_data = $req->only(['class_id', 'section_id'])->toArray();
        $mark_data['year'] = $exam_data['year'] = $academicSetting->current_session;

        $students = $studentRepository->getRecord($query_data)->get();

        if ($students->count() < 1) {
            $this->dispatchBrowserEvent('show-confirm', ['message' => __('msg.rnf'), 'type' => 'error']);
            return back();
        }

        foreach ($students as $student) {
            $mark_data['student_id'] = $exam_data['student_id'] = $student->id;
            $examRepository->createMark($mark_data);
            $examRepository->createRecord($exam_data);
        }

        return redirect()->route('marks.manage', [$this->exam_id, $this->class_id, $this->section_id, $this->subject_id]);
    }

}
