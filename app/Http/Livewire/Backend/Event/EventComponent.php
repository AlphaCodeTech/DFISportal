<?php

namespace App\Http\Livewire\Backend\Event;

use App\Models\Event;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;

class EventComponent extends Component
{
    use WithFileUploads;

    public $isEditing = false;
    public $toBeDeleted = null;
    public $state = [];
    public Event $event;
    public $selectedEvent;

    protected $listeners = ['delete' => 'destroy'];


    public function render()
    {
        $events = Event::all();
        return view('livewire.backend.event.event-component', compact('events'))->layout('backend.layouts.app');
    }

    public function create()
    {
        $this->isEditing = false;
        $this->state = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function store()
    {
        $colors = array('#FF5733','#351C17','#B4CF6D','#28A2DE','#8F29B8','#9B1384','#61915E','#28B3F4','#D8D145','#DDA4EA');

        $data =  Validator::make($this->state, [
            'name' => 'required|unique:events,name',
            'start' => 'required',
            'end' => 'required',
        ])->validate();
        
        $data['color'] = Arr::random($colors);

        Event::create($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'User created successfully!']);
    }

    public function edit(Event $event)
    {
        $this->event = $event;

        $this->isEditing = true;
        $this->state = $event->toArray();
        $this->dispatchBrowserEvent('show-form');
    }

    public function update()
    {

        $data =  Validator::make($this->state, [
            'name' => 'required|unique:events,name,'.$this->event->id,
            'start' => 'required',
            'end' => 'required',
        ])->validate();

        $this->event->update($data);

        $this->dispatchBrowserEvent('hide-modal', ['message' => 'Event updated successfully!']);
    }

    public function show(Event $event)
    {
        $this->selectedEvent = $event;
        $this->dispatchBrowserEvent('show-view');
    }

    public function confirmDelete($userId)
    {
        $this->toBeDeleted = $userId;
        $this->dispatchBrowserEvent('delete-modal', ['message' => 'Are you sure you want to delete this event?']);
    }

    public function destroy()
    {
        $event = Event::find($this->toBeDeleted);
        $event->delete();
        $this->dispatchBrowserEvent('show-confirm', ['message' => 'Event deleted successfully!']);
    }
}
