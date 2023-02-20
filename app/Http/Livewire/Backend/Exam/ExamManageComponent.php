<?php

namespace App\Http\Livewire\Backend\Exam;

use App\Helpers\QS;
use App\Models\Mark;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Settings\AcademicSetting;
use Illuminate\Support\Facades\App;
use App\Repositories\ExamRepository;
use App\Repositories\MarkRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClassRepository;

class ExamManageComponent extends Component
{
    use WithFileUploads;

    public $year;
    public $data = [];
    public $marks;
    public $firstMark;
    public $exam_id;
    public $class_id;
    public $section_id;
    public $subject_id;

    public function mount(
        AcademicSetting $academicSetting,
        ExamRepository $examRepository,
        ClassRepository $classRepository,
        $exam_id,
        $class_id,
        $section_id,
        $subject_id
    ) {
        $this->exam_id = $exam_id;
        $this->class_id = $class_id;
        $this->section_id = $section_id;
        $this->subject_id = $subject_id;

        $this->year = $academicSetting->current_session;

        $this->data = ['exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'year' => $this->year];

        $this->marks = $examRepository->getMark($this->data);

        if ($this->marks->count() < 1) {
            return $this->noStudentRecord();
        }

        $this->firstMark =  $this->marks->first();
        $this->data['exams'] = $examRepository->all();
        $this->data['classes'] = $classRepository->all();
        $this->data['sections'] = $classRepository->getAllSections();
        $this->data['subjects'] = $classRepository->getAllSubjects();
        if (Qs::userIsTeacher()) {
            $this->data['classes'] = $classRepository->findClassByTeacher(Auth::user()->id);
            $this->data['subjects'] = $classRepository->findSubjectByTeacher(Auth::user()->id);
        }
        $this->data['classLevel'] = $classRepository->findLevelByClass($class_id);
    }

    public function render()
    {
        return view('livewire.backend.exam.exam-manage')->layout('backend.layouts.app');
    }

    protected $rules = [
        'marks.*.t1' => 'required|integer|max:10',
        'marks.*.t2' => 'required|integer|max:30',
        'marks.*.exam' => 'required|integer|max:60'
    ];

    protected $messages = [
        'marks.*.t1.required' => 'The first CA field is required',
        'marks.*.t2.required' => 'The second CA field is required',
        'marks.*.exam.required' => 'The exam field is required',
        'marks.*.t1.max' => 'The first CA field must no be greater than 10',
        'marks.*.t2.max' => 'The second CA field must no be greater than 30',
        'marks.*.exam.max' => 'The exam field must no be greater than 60',
    ];

    public function update($exam_id, $class_id, $section_id, $subject_id)
    {
        $this->validate();
        
        $examRepository = App::make(ExamRepository::class);
        $classRepository = App::make(ClassRepository::class);
        $markRepository = App::make(MarkRepository::class);

        $parameters = ['exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'year' => $this->year];

        $data = $data3 = $all_students_ids = [];

        $examData = $examRepository->find($exam_id);
        $level = $classRepository->findLevelByClass($class_id);


        /** Test, Exam, Grade **/
        foreach ($this->marks->sortBy('user.name') as $mark) {
            $all_students_ids[] = $mark->student_id;

            $data['t1'] = $t1 = $mark->t1;
            $data['t2'] = $t2 = $mark->t2;
            $data['total_CA'] = $total_CA = $t1 + $t2;
            $data['exam'] = $exam = $mark->exam;


            /** SubTotal Grade, Remark, Cum, CumAvg**/

            $data['tex' . $examData->term->id] = $total = $total_CA + $exam;

            if ($total > 100) {
                $data['tex' . $examData->term->id] = $data['t1'] = $data['t2'] = $data['t3'] = $data['t4'] = $data['total_CA'] = $data['exam'] = NULL;
            }

            
            $grade = $markRepository->getGrade($total, $level->id);
            // dd($grade);
            $data['grade_id'] = $grade ? $grade->id : NULL;

            $examRepository->updateMark($mark->id, $data);
        }


        /** Sub Position Begin  **/

        foreach ($this->marks->sortBy('user.name') as $mark) {

            $data2['sub_pos'] = $markRepository->getSubPos($mark->student_id, $examData, $class_id, $subject_id, $this->year);

            $examRepository->updateMark($mark->id, $data2);
        }

        /*Sub Position End*/

        /* Exam Record Update */

        unset($parameters['subject_id']);

        foreach ($all_students_ids as $student_id) {

            $parameters['student_id'] = $student_id;
            $data3['total'] = $markRepository->getExamTotalTerm($examData, $student_id, $class_id, $this->year);
            $data3['average'] = $markRepository->getExamAvgTerm($examData, $student_id, $class_id, $section_id, $this->year);
            $data3['class_average'] = $markRepository->getClassAvg($examData, $class_id, $this->year);
            $data3['position'] = $markRepository->getPosition($student_id, $examData, $class_id, $section_id, $this->year);

            $examRepository->updateRecord($parameters, $data3);

        }
        /*Exam Record End*/

        $this->dispatchBrowserEvent('hide-modal', ['message' => __('msg.update_ok')]);

        $this->emit('refreshComponent');
    }


    protected function noStudentRecord()
    {
        alert('Error!', __('msg.srnf'), 'error');

        return redirect()->back();
    }
}
