<?php

namespace App\Http\Livewire\Backend\Classroom;

use App\Models\User;
use App\Models\Clazz;
use App\Models\Level;
use App\Models\Subject;
use Livewire\Component;
use App\Models\ClassSection;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ClassroomComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $class;
    public $selectedClass;
    public $levels;
    public $teachers;
    public $subjects;
    public $subject_ids = [];

    protected $listeners = ['delete' => 'destroy'];

    public function mount()
    {
        $this->subjects = Subject::all();
        // $this->selectedClass = Clazz::first();
        $this->levels = Level::all();
        $this->teachers = User::role('teacher')->get();
    }

    public function render()
    {
        $classes = Clazz::all();
        return view('livewire.backend.classroom.class-component', compact('classes'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:classes,name',
            'level_id' => 'required|exists:levels,id',
            'user_id' => 'nullable|exists:users,id',
        ])->validate();

        $class = Clazz::create([
            'name' => $data['name'],
            'level_id' => $data['level_id'],
        ]);

        ClassSection::create([
            'class_id' => $class->id,
            'name' => "A",
            'active' => 1,
            'user_id' => $data['user_id'],
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Classroom created successfully!']);
    }

    public function edit(Clazz $class)
    {
        $this->class = $class;
        // foreach($class->sections as $section){
        // };
        $this->isEditing = true;
        $this->state = $class->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function classSection(Clazz $class)
    {
        $this->selectedClass = $class;
        $this->state = $class->toArray();
        $this->dispatchBrowserEvent('show-section');
    }

    public function addSection()
    {
        $data = validator::make($this->state, [
            's_name' => [
                'required',
                Rule::unique('class_sections', 'name')
                    ->where(fn ($query) => $query
                        ->where('class_id', $this->selectedClass->id))
            ],

            'active' => 'required',
            'user_id' => 'required',
        ])->validate();

        ClassSection::create([
            'class_id' => $this->selectedClass->id,
            'name' => ucwords($data['s_name']),
            'active' => $data['active'],
            'user_id' => $data['user_id'],
        ]);

        $this->dispatchBrowserEvent('hide-section', ['message' => 'Section Added to Class successfully!']);
    }

    public function update()
    {
        $data =  Validator::make($this->state, [
            'name' => 'required|unique:classes,name,' . $this->class->id,
            'level_id' => 'required|exists:levels,id',
            'user_id' => 'required|exists:users,id',
        ])->validate();


        $this->class->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Class updated successfully!']);
    }

    public function show(Clazz $class)
    {
        $this->selectedClass = $class;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this class?']);
    }

    public function destroy()
    {
        $class = Clazz::find($this->toBeDeleted);
        $class->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Classroom deleted successfully!']);
    }

    public function showAssign(Clazz $clazz)
    {
        $this->selectedClass = $clazz;
        $this->subject_ids = $clazz->subjects->pluck('id')->toArray();
        $this->dispatchBrowserEvent('show-assign');
    }

    public function assign()
    {
        $data = Validator::make($this->state, [
            'class_id' => 'required|exists:classes,id',
        ])->validate();

        $id = $data['class_id'];

        $class = Clazz::find($id);

        $class->subjects()->sync($this->subject_ids);

        $this->dispatchBrowserEvent('hide-assign', ['message' => 'Subjects assigned to class successfully!']);
    }

    public function printData(Clazz $clazz)
    {
        $class = $clazz;

        if ($class) {

            $this->dispatchBrowserEvent('hide-view');
            $path = public_path() . '/frontend/logo.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $pdf = Pdf::loadView('livewire.backend.classroom.print', ['class' => $class, 'image' => $image])->setPaper('a4', 'landscape')->output();

            return response()->streamDownload(
                fn () => print($pdf),
                $class->name . '.pdf'
            );
        } else {
            alert('Sorry', 'No Student in this class', 'error');
            return redirect()->back();
        }
    }
}
