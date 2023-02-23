<?php

namespace App\Repositories;

use App\Models\Grade;
use App\Models\Mark;

class MarkRepository
{
    public function getGrade($total, $level_id)
    {
        if ($total < 1) {
            return NULL;
        }

        $grades = Grade::where(['level_id' => $level_id])->get();

        if ($grades->count() > 0) {
            $grade = $grades->where('mark_from', '<=', $total)->where('mark_to', '>=', $total);

            return $grade->count() > 0 ? $grade->first() : $this->getGrade2($total);
        }
        return $this->getGrade2($total);
    }

    public function getGrade2($total)
    {
        $grades = Grade::whereNull('level_id')->get();
        if ($grades->count() > 0) {
            return $grades->where('mark_from', '<=', $total)->where('mark_to', '>=', $total)->first();
        }
        return NULL;
    }

    public function getSubTotalTerm($st_id, $sub_id, $term, $class_id, $year)
    {
        // You may wish to get exam id from term Exam::where(['term' => $term, 'year' => $yr])
        $d = ['student_id' => $st_id, 'subject_id' => $sub_id, 'class_id' => $class_id, 'year' => $year];

        $tex = 'tex' . $term;
        $sub_total = Mark::where($d)->select($tex)->get()->where($tex, '>', 0);
        return $sub_total->count() > 0 ? $sub_total->first()->$tex : NULL;
    }

    public function getExamTotalTerm($exam, $student_id, $class_id, $year)
    {
        $data = ['student_id' => $student_id, 'exam_id' => $exam->id, 'class_id' => $class_id, 'year' => $year];

        $tex = 'tex' . $exam->term->id;
        $mark = Mark::where($data);
        return $mark->select($tex)->sum($tex);

        /*  unset($d['exam_id']);
        $mk =Mark::where($d);
        $t1 = $mk->select('tex1')->sum('tex1');
        $t2 = $mk->select('tex2')->sum('tex2');
        $t3 = $mk->select('tex3')->sum('tex3');
        return $t1 + $t2 + $t3;*/
    }

    public function getExamAvgTerm($exam, $student_id, $class_id, $section_id, $year)
    {
        $data = ['student_id' => $student_id, 'exam_id' => $exam->id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $year];

        $tex = 'tex' . $exam->term->id;

        $mark = Mark::where($data)->where($tex, '>', 0);
        $avg = $mark->select($tex)->avg($tex);
        return round($avg, 1);

        /*unset($d['exam_id']);
        $mk = Mark::where($d); $count = 0;

        $t1 = $mk->select('tex1')->avg('tex1');
        $t2 = $mk->select('tex2')->avg('tex2');
        $t3 = $mk->select('tex3')->avg('tex3');

        $count = $t1 ? $count + 1 : $count;
        $count = $t2 ? $count + 1 : $count;
        $count = $t3 ? $count + 1 : $count;

        $avg = $t1 + $t2 + $t3;
        return ($avg > 0) ? round($avg/$count, 1) : 0;*/
    }

    public function getSubCumTotal($tex3, $st_id, $sub_id, $class_id, $year)
    {
        $tex1 = $this->getSubTotalTerm($st_id, $sub_id, 1, $class_id, $year);
        $tex2 = $this->getSubTotalTerm($st_id, $sub_id, 2, $class_id, $year);
        return $tex1 + $tex2 + $tex3;
    }

    public function getSubCumAvg($tex3, $st_id, $sub_id, $class_id, $year)
    {
        $count = 0;
        $tex1 = $this->getSubTotalTerm($st_id, $sub_id, 1, $class_id, $year);
        $count = $tex1 ? $count + 1 : $count;
        $tex2 = $this->getSubTotalTerm($st_id, $sub_id, 2, $class_id, $year);
        $count = $tex2 ? $count + 1 : $count;
        $count = $tex3 ? $count + 1 : $count;
        $total = $tex1 + $tex2 + $tex3;

        return ($total > 0) ? round($total / $count, 1) : 0;
    }

    public function getSubjectMark($exam, $class_id, $subject_id, $student_id, $year)
    {
        $data = ['exam_id' => $exam->id, 'class_id' => $class_id, 'subject_id' => $subject_id, 'student_id' => $student_id, 'year' => $year];
        $tex = 'tex' . $exam->term->id;

        return Mark::where($data)->select($tex)->get()->first()->$tex;
    }

    public function getSubPos($student_id, $exam, $class_id, $subject_id, $year)
    {
        $data = ['exam_id' => $exam->id, 'class_id' => $class_id, 'subject_id' => $subject_id, 'year' => $year];
        $tex = 'tex' . $exam->term->id;

        $subject_mark = $this->getSubjectMark($exam, $class_id, $subject_id, $student_id, $year);

        $subject_marks = Mark::where($data)->whereNotNull($tex)->orderBy($tex, 'DESC')->select($tex)->get()->pluck($tex);
        return $sub_pos = $subject_marks->count() > 0 ? $subject_marks->search($subject_mark) + 1 : NULL;
    }

    public function countExSubjects($exam, $st_id, $class_id, $year)
    {
        $d = ['exam_id' => $exam->id, 'my_class_id' => $class_id, 'student_id' => $st_id, 'year' => $year];
        $tex = 'tex' . $exam->term->id;

        if ($exam->term->id == 3) {
            unset($d['exam_id']);
        }

        return Mark::where($d)->whereNotNull($tex)->count();
    }

    public function getClassAvg($exam, $class_id, $year)
    {
        $data = ['exam_id' => $exam->id, 'class_id' => $class_id, 'year' => $year];
        $tex = 'tex' . $exam->term->id;

        $avg = Mark::where($data)->select($tex)->avg($tex);
        return round($avg, 1);
    }

    public function getPosition($student_id, $exam, $class_id, $section_id, $year)
    {
        $data = ['student_id' => $student_id, 'exam_id' => $exam->id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $year];
        $all_mks = [];
        $tex = 'tex' . $exam->term->id;

        $my_mk = Mark::where($data)->select($tex)->sum($tex);

        /*if($exam->term == 3){
            $my_mk = Mark::where($d)->select('cum')->sum('cum');
        }*/

        unset($data['student_id']);
        $mark = Mark::where($data);
        $students = $mark->select('student_id')->distinct()->get();
        foreach ($students as $student) {
            $all_mks[] = $this->getExamTotalTerm($exam, $student->student_id, $class_id, $year);
        }
        rsort($all_mks);
        return array_search($my_mk, $all_mks) + 1;
    }

    public function getSubjectIDs($data)
    {
        return Mark::distinct()->select('subject_id')->where($data)->get()->pluck('subject_id');
    }

    public function getStudentIDs($data)
    {
        return Mark::distinct()->select('student_id')->where($data)->get()->pluck('student_id');
    }
}
