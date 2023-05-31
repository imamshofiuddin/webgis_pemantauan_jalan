<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoadMapController extends Controller
{
    public function index(Request $request)
    {
        return view('landing-page');
    }

    public function toRoadMap(Request $request)
    {
        return view('roads.map');
    }
}
