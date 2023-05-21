<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class RoadController extends Controller
{
    public function index() {
        $roadQuery = Place::query();
        $roadQuery->where('place_name','like','%'.request('q').'%');
        $roads = $roadQuery->paginate(25);

        return view('roads.index', compact('roads'));
    }

    public function create() {
        return view('roads.create');
    }

    public function store(Request $request){
        $request->validate([
            'place_name' => 'required',
            'address' => 'nullable',
            'latitude' => ['required', 'required_with:longitude|15'],
            'longitude' => ['required', 'required_with:latitude|15'],
        ]);

        $road = new Place();
        $road->user_contributor_id = Auth::user()->id;
        $road->place_name = $request->input('place_name');
        $road->address = $request->input('address');
        $road->description = $request->input('description');
        $road->latitude = $request->input('latitude');
        $road->longitude = $request->input('longitude');
        $road->condition = $request->input('condition');

        $road->save();

        return redirect()->route('roads.show', $road);
    }

    public function show(Place $road){
        return view('roads.show', compact('road'));
    }

    public function edit(Place $road){
        return view('roads.edit', compact('road'));
    }

    public function update(Request $request, Place $road){
        $request->validate([
            'place_name' => 'required',
            'address' => 'nullable',
            'latitude' => ['required', 'required_with:longitude|15'],
            'longitude' => ['required', 'required_with:latitude|15'],
        ]);

        $road->place_name = $request->input('place_name');
        $road->address = $request->input('address');
        $road->latitude = $request->input('latitude');
        $road->longitude = $request->input('longitude');

        $road->update();
        return redirect()->route('roads.show', $road);
    }

    public function destroy(Request $request, Place $road){
        $request->validate(['road_id' => 'required']);

        if($request->input('road_id') == $road->id && $road->delete()){
            return redirect()->route('roads.index');
        }

        return back();
    }
}
