<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class RoadController extends Controller
{
    public function index() {
        $roadQuery = Place::where('isConfirmed','=',true);
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
            'photo' => 'required',
            'address' => 'nullable',
            'latitude' => ['required', 'required_with:longitude|15'],
            'longitude' => ['required', 'required_with:latitude|15'],
        ]);

        $road = new Place();
        $photoName =  rand().'_'.$request->file('photo')->getClientOriginalName();
        $request->file('photo')->move('upload/foto_jalan/',$photoName);
        $road->place_name = $request->input('place_name');
        $road->address = $request->input('address');
        $road->description = $request->input('description');
        $road->latitude = $request->input('latitude');
        $road->longitude = $request->input('longitude');
        $road->condition = $request->input('condition');
        $road->image = $photoName;

        if (Auth::user()) {
            $road->user_contributor_id = Auth::user()->id;
        } else {
            $guest = User::where('name','=','guest')->first();
            $road->user_contributor_id = $guest->id;
        }

        $road->save();

        if (Auth::user()) {
            return redirect()->route('roads.show', $road);
        } else {
            return redirect()->route('road_map.index')->with('message', 'Laporanmu kini sedang dalam pengecekan');
        }


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
        if(($request->file('photo')) !== null){
            $photoName =  rand().'_'.$request->file('photo')->getClientOriginalName();
            $request->file('photo')->move('upload/foto_jalan/',$photoName);
            $road->image = $photoName;
        }

        $road->place_name = $request->input('place_name');
        $road->condition = $request->input('condition');
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

    public function roadFixedUpdate(Place $road){
        if ($road->isFixed == false) {
            $road->isFixed = true;
        } else {
            $road->isFixed = false;
        }

        $road->update();
        return redirect()->back();
    }

    public function roadReport(){
        $roadQuery = Place::where('isConfirmed','=',false);
        $roads = $roadQuery->paginate(25);

        return view('roads.report', compact('roads'));
    }

    public function confirmReport(Place $road){
        if(isset($_POST['accept'])){
            if ($road->isConfirmed == false) {
                $road->isConfirmed = true;
            } else {
                $road->isConfirmed = false;
            }

            $road->update();
        } else {
            $road->delete();
        }

        return redirect()->route('roads.report');
    }

    public function roadStatistic(){
        $roadQuery = Place::where('isConfirmed','=',true);
        $roadsConfirmed = $roadQuery->paginate(25);
        $roadsNotConfirmedQuery = Place::where('isConfirmed','=',false);
        $roadsNoConfirmed = $roadsNotConfirmedQuery->paginate(25);
        $totalReport = Place::all()->count();
        $totalReportApprove = Place::where('isConfirmed','=',true)->count();
        $totalWaitingReport = $totalReport - $totalReportApprove;
        $roadCondition = DB::select("SELECT count(place_name) as 'Total', `condition` FROM `places` WHERE isConfirmed = 1 GROUP BY `condition`");
        $roadFixed = DB::select("SELECT count(isFixed) as 'Total', isFixed FROM `places` WHERE isConfirmed = 1 GROUP BY isFixed");
        $dataRoadCondition = "";
        $dataRoadFixed = "";
        foreach ($roadCondition as $val) {
            $dataRoadCondition .= "['".$val->condition."',".$val->Total."],";
        }
        foreach ($roadFixed as $val) {
            $roadStatus = "";
            if($val->isFixed){
                $roadStatus = "Sudah diperbaiki";
            } else {
                $roadStatus = "Belum diperbaiki";
            }
            $dataRoadFixed .= "['".$roadStatus."',".$val->Total."],";
        }
        $chartDataRoadCondition = $dataRoadCondition;
        $chartDataRoadFixed = $dataRoadFixed;
        return view('statistic', compact('chartDataRoadCondition', 'chartDataRoadFixed','totalReport','totalWaitingReport','totalReportApprove','roadsConfirmed','roadsNoConfirmed'));
    }
}
