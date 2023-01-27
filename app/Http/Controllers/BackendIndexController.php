<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class BackendIndexController extends Controller
{
    public function index(Request $request)
    {
        $eventsData = array();

        $events = Event::all();
        foreach ($events as $e) {
            $eventsData[] = [
                'title' => $e->name,
                'start' => $e->start,
                'end' => $e->end,
                'id' => $e->id,
                'color' => $e->color,
            ];
        }

        return view('backend.index', compact('eventsData'));
    }

    public function calendarEvents(Request $request)
    {
        $colors = array('#FF5733','#351C17','#B4CF6D','#28A2DE','#8F29B8','#9B1384','#61915E','#28B3F4','#D8D145','#DDA4EA');

        switch ($request->type) {
            case 'create':
                $request->validate([
                    'name' => 'required|string',
                ]);

                $event = Event::create([
                    'name' => $request->name,
                    'start' => $request->start,
                    'end' => $request->end,
                    'color' => Arr::random($colors),
                ]);

                return response()->json($event);
                break;

            case 'edit':
                $event = Event::find($request->id)->update([
                    'name' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # ...
                break;
        }
    }
}
