<?php

namespace App\Repositories;

use App\Models\Clazz;
use App\Models\Level;
use App\Models\Subject;
use App\Models\ClassSection;

class ClassRepository
{

    public function all()
    {
        return Clazz::orderBy('name', 'asc')->with('class_type')->get();
    }

    public function getMC($data)
    {
        return Clazz::where($data)->with('section');
    }

    public function find($id)
    {
        return Clazz::find($id);
    }

    public function create($data)
    {
        return Clazz::create($data);
    }

    public function update($id, $data)
    {
        return Clazz::find($id)->update($data);
    }

    public function delete($id)
    {
        return Clazz::destroy($id);
    }

    public function getLevels()
    {
        return Level::orderBy('name', 'asc')->get();
    }

    public function findLevel($class_type_id)
    {
        return Level::find($class_type_id);
    }

    public function findLevelByClass($class_id)
    {
        return Level::find($this->find($class_id)->class_type_id);
    }

    /************* Section *******************/

    public function createSection($data)
    {
        return ClassSection::create($data);
    }

    public function findSection($id)
    {
        return ClassSection::find($id);
    }

    public function updateSection($id, $data)
    {
        return ClassSection::find($id)->update($data);
    }

    public function deleteSection($id)
    {
        return ClassSection::destroy($id);
    }

    public function isActiveSection($section_id)
    {
        return ClassSection::where(['id' => $section_id, 'active' => 1])->exists();
    }

    public function getAllSections()
    {
        return ClassSection::orderBy('name', 'asc')->with(['my_class', 'teacher'])->get();
    }

    public function getClassSections($class_id)
    {
        return ClassSection::where('class_id', $class_id)->orderBy('name', 'asc')->get();
    }

    /************* Subject *******************/

    public function createSubject($data)
    {
        return Subject::create($data);
    }

    public function findSubject($id)
    {
        return Subject::find($id);
    }

    public function findSubjectByClass($class_id, $order_by = 'name')
    {
        return $this->getSubject(['my_class_id'=> $class_id])->orderBy($order_by)->get();
    }

    public function findSubjectByTeacher($teacher_id, $order_by = 'name')
    {
        return $this->getSubject(['teacher_id'=> $teacher_id])->orderBy($order_by)->get();
    }

    public function getSubject($data)
    {
        return Subject::where($data);
    }

    public function getSubjectsByIDs($ids)
    {
        return Subject::whereIn('id', $ids)->orderBy('name')->get();
    }

    public function updateSubject($id, $data)
    {
        return Subject::find($id)->update($data);
    }

    public function deleteSubject($id)
    {
        return Subject::destroy($id);
    }

    public function getAllSubjects()
    {
        return Subject::orderBy('name', 'asc')->with(['my_class', 'teacher'])->get();
    }

}