<?php

namespace App\Repositories;

use App\Helpers\Qs;
use App\Models\Promotion;
use App\Models\Student;

class StudentRepository {


    public function findStudentsByClass($class_id)
    {
        return $this->activeStudents()->where(['class_id' => $class_id])->with(['guardian', 'class'])->get();
    }

    public function activeStudents()
    {
        return Student::where(['admitted' => 1]);
    }

    public function gradStudents()
    {
        return Student::where(['graduated' => 1])->orderByDesc('graduation_date');
    }

    public function allGradStudents()
    {
        return $this->gradStudents()->with(['class', 'section'])->get()->sortBy('name');
    }

    public function findStudentsBySection($sec_id)
    {
        return $this->activeStudents()->where('section_id', $sec_id)->with(['guardian', 'class'])->get();
    }

    public function createRecord($data)
    {
        return Student::create($data);
    }

    public function updateRecord($id, array $data)
    {
        return Student::find($id)->update($data);
    }

    public function update(array $where, array $data)
    {
        return Student::where($where)->update($data);
    }

    public function getRecord(array $data)
    {
        return $this->activeStudents()->where($data);
    }

    public function getRecordByUserIDs($ids)
    {
        return $this->activeStudents()->whereIn('id', $ids);
    }

    public function findByUserId($st_id)
    {
        return $this->getRecord(['user_id' => $st_id]);
    }

    public function getAll()
    {
        return $this->activeStudents()->with('user');
    }

    public function getGradRecord($data=[])
    {
        return $this->gradStudents()->where($data)->with('user');
    }


    public function exists($student_id)
    {
        return $this->getRecord(['id' => $student_id])->exists();
    }

    /************* Promotions *************/
    public function createPromotion(array $data)
    {
        return Promotion::create($data);
    }

    public function findPromotion($id)
    {
        return Promotion::find($id);
    }

    public function deletePromotion($id)
    {
        return Promotion::destroy($id);
    }

    public function getAllPromotions()
    {
        return Promotion::with(['student', 'fromClass', 'toClass', 'fromSection', 'toSection'])->where(['current_session' => Qs::getCurrentSession(), 'next_session' => Qs::getNextSession()])->get();
    }

    public function getPromotions(array $where)
    {
        return Promotion::where($where)->get();
    }

}
