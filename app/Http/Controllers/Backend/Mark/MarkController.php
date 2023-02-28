<?php

namespace App\Http\Controllers\Backend\Mark;

use App\Helpers\Mk;
use App\Helpers\Qs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ExamRepository;
use App\Repositories\MarkRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClassRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Session;

class MarkController extends Controller
{
    protected $class, $exam, $student, $year, $user, $mark;

    public function __construct(ClassRepository $class, ExamRepository $exam, StudentRepository $student, MarkRepository $mark)
    {
        $this->exam =  $exam;
        $this->mark =  $mark;
        $this->student =  $student;
        $this->class =  $class;
        $this->year =  Qs::getSetting('current_session');

        // $this->middleware('teamSAT', ['except' => ['show', 'year_selected', 'year_selector', 'print_view'] ]);
    }

    public function year_selector($student_id)
    {
        return $this->verifyStudentExamYear($student_id);
    }

    public function year_selected(Request $req, $student_id)
    {
        if (!$this->verifyStudentExamYear($student_id, $req->year)) {
            return $this->noStudentRecord();
        }

        return redirect()->route('marks.show', [$student_id, $req->year]);
    }

    public function show($student_id, $year)
    {
        /* Prevent Other Students/Parents from viewing Result of others */
        if (Auth::user()->id != $student_id && !Qs::userIsTeamSAT() && !Qs::userIsMyChild($student_id, Auth::user()->id)) {
            alert('Sorry', __('msg.denied'), 'error');
            return redirect(route('backend.index'));
        }

        if (Mk::examIsLocked() && !Qs::userIsTeamSA()) {
            Session::put('marks_url', route('marks.show', [$student_id, $year]));

            if (!$this->checkPinVerified($student_id)) {
                return redirect()->route('pins.enter', $student_id);
            }
        }

        if (!$this->verifyStudentExamYear($student_id, $year)) {
            return $this->noStudentRecord();
        }

        $where = ['student_id' => $student_id, 'year' => $year];

        $data['marks'] = $this->exam->getMark($where);
        $data['exam_records'] = $exam_record = $this->exam->getRecord($where);
        $data['exams'] = $this->exam->getExam(['year' => $year]);
        $data['student_record'] = $this->student->getRecord(['id' => $student_id])->first();
        $data['class'] = $class = $this->class->getMC(['id' => $exam_record->first()->class_id])->first();
        $data['classLevel'] = $this->class->findLevelByClass($class->id);
        $data['subjects'] = $this->class->findSubjectByClass($class->id);
        $data['year'] = $year;
        $data['student_id'] = $student_id;
        $data['skills'] = $this->exam->getSkillByClassType() ?: NULL;
        //3897
        // dd($data);
        return view('backend.mark-include', compact('data'));
    }

    public function print_view($student_id, $exam_id, $year)
    {
        /* Prevent Other Students/Parents from viewing Result of others */
        if (Auth::user()->id != $student_id && !Qs::userIsTeamSA() && !Qs::userIsMyChild($student_id, Auth::user()->id)) {
            alert('Sorry', __('msg.denied'), 'error');
            return redirect(route('backend.index'));
        }

        if (Mk::examIsLocked() && !Qs::userIsTeamSA()) {
            Session::put('marks_url', route('marks.show', [$student_id, $year]));

            if (!$this->checkPinVerified($student_id)) {
                return redirect()->route('pins.enter', $student_id);
            }
        }

        if (!$this->verifyStudentExamYear($student_id, $year)) {
            return $this->noStudentRecord();
        }

        $where = ['student_id' => $student_id, 'exam_id' => $exam_id, 'year' => $year];
        $data['marks'] = $marks = $this->exam->getMark($where);
        $data['exam_record'] = $exam_record = $this->exam->getRecord($where)->first();
        $data['class'] = $class = $this->class->find($exam_record->class_id);
        $data['section_id'] = $exam_record->section_id;
        $data['exam'] = $exam = $this->exam->find($exam_id);
        $data['tex'] = 'tex' . $exam->term->id;
        $data['student_record'] = $student_record = $this->student->getRecord(['id' => $student_id])->first();
        $data['class_level'] = $this->class->findLevelByClass($class->id);
        $data['subjects'] = $this->class->findSubjectByClass($class->id);

        $data['cl'] = $cl = $data['class_level']->code;
        $data['year'] = $year;
        $data['student_id'] = $student_id;
        $data['exam_id'] = $exam_id;

        $data['skills'] = $this->exam->getSkillByClassType() ?: NULL;

        // dd($data);

        return view('backend.print-index', $data);
    }

    public function manage($exam_id, $class_id, $section_id, $subject_id)
    {
        $d = ['exam_id' => $exam_id, 'my_class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'year' => $this->year];

        $d['marks'] = $this->exam->getMark($d);
        if ($d['marks']->count() < 1) {
            return $this->noStudentRecord();
        }

        $d['m'] =  $d['marks']->first();
        $d['exams'] = $this->exam->all();
        $d['my_classes'] = $this->my_class->all();
        $d['sections'] = $this->my_class->getAllSections();
        $d['subjects'] = $this->my_class->getAllSubjects();
        if (Qs::userIsTeacher()) {
            $d['subjects'] = $this->my_class->findSubjectByTeacher(Auth::user()->id)->where('my_class_id', $class_id);
        }
        $d['selected'] = true;
        $d['class_type'] = $this->my_class->findTypeByClass($class_id);

        return view('pages.support_team.marks.manage', $d);
    }

    public function update(Request $req, $exam_id, $class_id, $section_id, $subject_id)
    {
        $p = ['exam_id' => $exam_id, 'my_class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'year' => $this->year];

        $d = $d3 = $all_st_ids = [];

        $exam = $this->exam->find($exam_id);
        $marks = $this->exam->getMark($p);
        $class_type = $this->my_class->findTypeByClass($class_id);

        $ar = $req->all();

        /** Test, Exam, Grade **/
        foreach ($marks->sortBy('user.name') as $mk) {
            $all_st_ids[] = $mk->student_id;

            $d['t1'] = $t1 = $ar['t1_' . $mk->id];
            $d['t2'] = $t2 = $mks['t2_' . $mk->id];
            $d['tca'] = $tca = $t1 + $t2;
            $d['exm'] = $exm = $mks['exm_' . $mk->id];


            /** SubTotal Grade, Remark, Cum, CumAvg**/

            $d['tex' . $exam->term] = $total = $tca + $exm;

            if ($total > 100) {
                $d['tex' . $exam->term] = $d['t1'] = $d['t2'] = $d['t3'] = $d['t4'] = $d['tca'] = $d['exm'] = NULL;
            }

            /*   if($exam->term < 3){
                $grade = $this->mark->getGrade($total, $class_type->id);
            }

            if($exam->term == 3){
                $d['cum'] = $this->mark->getSubCumTotal($total, $st_id, $subject_id, $class_id, $this->year);
                $d['cum_ave'] = $cav = $this->mark->getSubCumAvg($total, $st_id, $subject_id, $class_id, $this->year);
                $grade = $this->mark->getGrade(round($cav), $class_type->id);
            }*/
            $grade = $this->mark->getGrade($total, $class_type->id);
            $d['grade_id'] = $grade ? $grade->id : NULL;

            $this->exam->updateMark($mk->id, $d);
        }

        /** Sub Position Begin  **/

        foreach ($marks->sortBy('user.name') as $mk) {

            $d2['sub_pos'] = $this->mark->getSubPos($mk->student_id, $exam, $class_id, $subject_id, $this->year);

            $this->exam->updateMark($mk->id, $d2);
        }

        /*Sub Position End*/

        /* Exam Record Update */

        unset($p['subject_id']);

        foreach ($all_st_ids as $st_id) {

            $p['student_id'] = $st_id;
            $d3['total'] = $this->mark->getExamTotalTerm($exam, $st_id, $class_id, $this->year);
            $d3['ave'] = $this->mark->getExamAvgTerm($exam, $st_id, $class_id, $section_id, $this->year);
            $d3['class_ave'] = $this->mark->getClassAvg($exam, $class_id, $this->year);
            $d3['pos'] = $this->mark->getPos($st_id, $exam, $class_id, $section_id, $this->year);

            $this->exam->updateRecord($p, $d3);
        }
        /*Exam Record End*/

        return Qs::jsonUpdateOk();
    }

    public function batch_fix()
    {
        $d['exams'] = $this->exam->getExam(['year' => $this->year]);
        $d['my_classes'] = $this->class->all();
        $d['sections'] = $this->class->getAllSections();
        $d['selected'] = false;

        return view('pages.support_team.marks.batch_fix', $d);
    }

    public function batch_update(Request $req): \Illuminate\Http\JsonResponse
    {
        $exam_id = $req->exam_id;
        $class_id = $req->my_class_id;
        $section_id = $req->section_id;

        $w = ['exam_id' => $exam_id, 'my_class_id' => $class_id, 'section_id' => $section_id, 'year' => $this->year];

        $exam = $this->exam->find($exam_id);
        $exrs = $this->exam->getRecord($w);
        $marks = $this->exam->getMark($w);

        /** Marks Fix Begin **/

        $class_type = $this->my_class->findTypeByClass($class_id);
        $tex = 'tex' . $exam->term;

        foreach ($marks as $mk) {

            $total = $mk->$tex;
            $d['grade_id'] = $this->mark->getGrade($total, $class_type->id);

            /*      if($exam->term == 3){
                      $d['cum'] = $this->mark->getSubCumTotal($total, $mk->student_id, $mk->subject_id, $class_id, $this->year);
                      $d['cum_ave'] = $cav = $this->mark->getSubCumAvg($total, $mk->student_id, $mk->subject_id, $class_id, $this->year);
                      $grade = $this->mark->getGrade(round($mk->cum_ave), $class_type->id);
                  }*/

            $this->exam->updateMark($mk->id, $d);
        }

        /* Marks Fix End*/

        /** Exam Record Update  **/
        foreach ($exrs as $exr) {

            $st_id = $exr->student_id;

            $d3['total'] = $this->mark->getExamTotalTerm($exam, $st_id, $class_id, $this->year);
            $d3['ave'] = $this->mark->getExamAvgTerm($exam, $st_id, $class_id, $section_id, $this->year);
            $d3['class_ave'] = $this->mark->getClassAvg($exam, $class_id, $this->year);
            $d3['pos'] = $this->mark->getPos($st_id, $exam, $class_id, $section_id, $this->year);

            $this->exam->updateRecord(['id' => $exr->id], $d3);
        }

        /** END Exam Record Update END **/

        return Qs::jsonUpdateOk();
    }

    public function comment_update(Request $req, $exr_id)
    {
        $d = QS::userIsTeamSA() ? $req->only(['t_comment', 'p_comment']) : $req->only(['t_comment']);

        $this->exam->updateRecord(['id' => $exr_id], $d);
        toast(__('msg.update_ok'), 'success');
        return redirect()->back();
    }

    public function skills_update(Request $req, $skill, $exam_record_id)
    {
        $data = [];
        if ($skill == 'AF' || $skill == 'PS') {
            $sk = strtolower($skill);
            $data[$skill] = implode(',', $req->$sk);
        }

        $this->exam->updateRecord(['id' => $exam_record_id], $data);
        toast(__('msg.update_ok'), 'success');
        return redirect()->back();
    }

    public function bulk_select(Request $req)
    {
        return redirect()->route('marks.bulk', [$req->my_class_id, $req->section_id]);
    }

    public function print_tabulation($exam_id, $class_id, $section_id)
    {
        $where = ['class_id' => $class_id, 'section_id' => $section_id, 'exam_id' => $exam_id, 'year' => $this->year];

        $subject_ids = $this->mark->getSubjectIDs($where);
        $student_ids = $this->mark->getStudentIDs($where);

        if (count($subject_ids) < 1 or count($student_ids) < 1) {
            return Qs::goWithDanger('marks.tabulation', __('msg.srnf'));
        }

        $data['subjects'] = $this->class->getSubjectsByIDs($subject_ids);
        $data['students'] = $this->student->getRecordByUserIDs($student_ids)->get()->sortBy('user.name');

        $data['class_id'] = $class_id;
        $data['exam_id'] = $exam_id;
        $data['year'] = $this->year;
        $where = ['exam_id' => $exam_id, 'class_id' => $class_id];
        $data['marks']  = $this->exam->getMark($where);
        $data['exam_record'] = $this->exam->getRecord($where);

        $data['class'] = $this->class->find($class_id);
        $data['section']  = $this->class->findSection($section_id);
        $data['exam'] = $exam = $this->exam->find($exam_id);
        $data['tex'] = 'tex' . $exam->term->id;
    // dd($data);
        return view('backend.tabulation-print', $data);
    }

    public function tabulation_select(Request $req)
    {
        return redirect()->route('marks.tabulation', [$req->exam_id, $req->my_class_id, $req->section_id]);
    }

    protected function verifyStudentExamYear($student_id, $year = null)
    {
        $years = $this->exam->getExamYears($student_id);
        $student_exists = $this->student->exists($student_id);

        if (!$year) {
            if ($student_exists && $years->count() > 0) {
                $data = ['years' => $years, 'student_id' => $student_id];

                return view('backend.include', compact('data'));
            }

            return $this->noStudentRecord();
        }

        return ($student_exists && $years->contains('year', $year)) ? true  : false;
    }

    protected function noStudentRecord()
    {
        alert('Error!', __('msg.srnf'), 'error');

        return redirect()->back();
    }

    protected function checkPinVerified($student_id)
    {
        return Session::has('pin_verified') && Session::get('pin_verified') == $student_id;
    }
}
