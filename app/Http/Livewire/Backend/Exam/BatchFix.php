<?php

namespace App\Http\Livewire\Backend\Exam;

use App\Helpers\QS;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Repositories\ExamRepository;
use App\Repositories\MarkRepository;
use App\Repositories\ClassRepository;

class BatchFix extends Component
{
    public $exams;
    public $classes;
    public $sections;
    public $year;
    public $selected = false;

    public $selectedClass = null;
    public $selectedExam = null;
    public $selectedSection = null;

    public function mount(ExamRepository $examRepository, ClassRepository $classRepository)
    {
        $this->year = QS::getSetting('current_session');
        $this->exams = $examRepository->getExam(['year' => $this->year]);
        $this->classes = $classRepository->all();
        $this->selected = false;
    }

    public function render()
    {
        return view('livewire.backend.exam.batch-fix')->layout('backend.layouts.app');
    }

    public function updatedSelectedClass($value)
    {
        $classRepository = App::make(ClassRepository::class);
        $this->sections = $classRepository->getClassSections($value);
    }


    public function batch_update()
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

        $examRepository = App::make(ExamRepository::class);
        $classRepository = App::make(ClassRepository::class);
        $markRepository = App::make(MarkRepository::class);

        $exam_id = $this->selectedExam;
        $class_id = $this->selectedClass;
        $section_id = $this->selectedSection;

        $where = ['exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $this->year];

        $exam = $examRepository->find($exam_id);
        $exam_records = $examRepository->getRecord($where);
        $marks = $examRepository->getMark($where);

        /** Marks Fix Begin **/

        $classLevel = $classRepository->findLevelByClass($class_id);
        $tex = 'tex' . $exam->term->id;

        foreach ($marks as $mark) {

            $total = $mark->$tex;
            $data['grade_id'] = $markRepository->getGrade($total, $classLevel->id)->id;

            $examRepository->updateMark($mark->id, $data);
        }

        /* Marks Fix End*/

        /** Exam Record Update  **/
        foreach ($exam_records as $exam_record) {

            $student_id = $exam_record->student_id;

            $data3['total'] = $markRepository->getExamTotalTerm($exam, $student_id, $class_id, $this->year);
            $data3['average'] = $markRepository->getExamAvgTerm($exam, $student_id, $class_id, $section_id, $this->year);
            $data3['class_average'] = $markRepository->getClassAvg($exam, $class_id, $this->year);
            $data3['position'] = $markRepository->getPosition($student_id, $exam, $class_id, $section_id, $this->year);

            $examRepository->updateRecord(['id' => $exam_record->id], $data3);
        }

        /** END Exam Record Update END **/
        $this->dispatchBrowserEvent('show-confirm', ['message' => __('msg.update_ok')]);
    }
}
