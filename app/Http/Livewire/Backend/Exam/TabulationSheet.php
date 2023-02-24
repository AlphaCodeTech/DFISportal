<?php

namespace App\Http\Livewire\Backend\Exam;

use App\Helpers\QS;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Repositories\ExamRepository;
use App\Repositories\MarkRepository;
use App\Repositories\ClassRepository;
use App\Repositories\StudentRepository;

class TabulationSheet extends Component
{
    public $classes;
    public $exams;
    public $subjects;
    public $students;
    public $sections;
    public $exam_record;
    public $marks;
    public $class;
    public $section;
    public $exam;
    public $year;
    public $class_id;
    public $section_id;
    public $exam_id;
    public $tex;
    public $selected = false;

    public $selectedClass = null;
    public $selectedExam = null;
    public $selectedSection = null;

    public function mount(
        ClassRepository $classRepository,
        ExamRepository $examRepository,
        MarkRepository $markRepository,
        StudentRepository $studentRepository,
        $exam_id = null,
        $class_id = null,
        $section_id = null
    ) {
        $this->year =  QS::getSetting('current_session');
        $this->classes = $classRepository->all();
        $this->exams = $examRepository->getExam(['year' => $this->year]);
        $this->selected = false;

        if ($class_id && $exam_id && $section_id) {

            $where = ['class_id' => $class_id, 'section_id' => $section_id, 'exam_id' => $exam_id, 'year' => $this->year];
            
            $subject_IDS = $markRepository->getSubjectIDs($where);
            $student_IDS = $markRepository->getStudentIDs($where);

            if (count($subject_IDS) < 1 or count($student_IDS) < 1) {
                return QS::goWithDanger('marks.tabulation', __('msg.srnf'));
            }

            $this->subjects = $classRepository->getSubjectsByIDs($subject_IDS);
            $this->students = $studentRepository->getRecordByUserIDs($student_IDS)->get()->sortBy('name');
            $this->sections = $classRepository->getAllSections();

            $this->selected = true;
            $this->class_id = $class_id;
            $this->section_id = $section_id;
            $this->exam_id = $exam_id;
            $this->year = $this->year;
            $this->marks = $examRepository->getMark($where);
            $this->exam_record = $examRepository->getRecord($where);

            $this->class = $classRepository->find($class_id);
            $this->section  = $classRepository->findSection($section_id);
            $this->exam = $exam = $examRepository->find($exam_id);
            $this->tex = 'tex' . $exam->term->id;
        }
        // dd($this);
    }

    public function render()
    {
        return view('livewire.backend.exam.tabulation-sheet')->layout('backend.layouts.app');
    }

    public function updatedSelectedClass($value)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->sections = $classRepository->getClassSections($value);
    }

    public function tabulation_select()
    {
        $this->validate([
            'selectedExam' => 'required',
            'selectedClass' => 'required',
            'selectedSection' => 'required',
        ], [
            'selectedExam' => 'the exam field is required',
            'selectedClass' => 'the class field is required',
            'selectedSection' => 'the section field is required',
        ]);

        return redirect()->route('marks.tabulation', [$this->selectedExam, $this->selectedClass, $this->selectedSection]);
    }
}
