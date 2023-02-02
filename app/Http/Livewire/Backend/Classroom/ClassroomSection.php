<?php

namespace App\Http\Livewire\Backend\Classroom;

use App\Models\User;
use App\Models\Clazz;
use Livewire\Component;
use App\Models\ClassSection;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ClassroomSection extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public $section;
    public $selectedSection;
    public $levels;
    public $teachers;

    protected $listeners = ['delete' => 'destroy'];

    public function mount(ClassSection $classSection)
    {
        $this->section = $classSection;
        // dd($this->section->teachers);

        $this->teachers = User::role('teacher')->get();
    }

    public function render()
    {
        $section = ClassSection::find($this->section->id);
        return view('livewire.backend.classroom.class-section', compact('section'))->layout('backend.layouts.app');
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

    public function edit(ClassSection $classSection)
    {
        $this->state = $classSection->toArray();
        $this->dispatchBrowserEvent('show-section');
    }

    public function updateSection()
    {
        $data = validator::make($this->state, [
            'name' => [
                'required',
                Rule::unique('class_sections', 'name')
                    ->where(fn ($query) => $query
                        ->where('class_id', $this->section->class_id))->ignore($this->section->id)
            ],
            'active' => 'required',
            'user_id' => 'required',
        ])->validate();

        $this->section->update($data);

        $this->dispatchBrowserEvent('hide-section', ['message' => 'Section Updated Successfully!']);
    }

    public function show(ClassSection $classSection)
    {
        $this->selectedSection = $classSection;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this section?']);
    }

    public function destroy()
    {
        $section = ClassSection::find($this->toBeDeleted);
        $section->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Class Section deleted successfully!']);

        return redirect()->route('backend.classrooms');
    }

    public function printData(ClassSection $classSection)
    {
        $section = $classSection;

        if (count($section->class->students) > 0) {

            $this->dispatchBrowserEvent('hide-view');
            $path = public_path() . '/frontend/logo.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $image = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $pdf = Pdf::loadView('livewire.backend.classroom.section', ['section' => $section, 'image' => $image])->setPaper('a4', 'landscape')->output();

            return response()->streamDownload(
                fn () => print($pdf),
                $section->name . '.pdf'
            );
        } else {
            alert('Sorry', 'No Student in this section', 'error');

            $this->dispatchBrowserEvent('hide-view');
        }
    }
}
