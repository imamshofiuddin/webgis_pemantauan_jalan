<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Road as RoadResource;
use App\Models\Place;
use Illuminate\Http\Request;

class RoadController extends Controller
{
    public function index(Request $request){
        $roads = Place::where('isConfirmed','=',true)->get();

        $geoJSONdata = $roads->map(function ($road) {
            return [
                'type'       => 'Feature',
                'properties' => new RoadResource($road),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $road->longitude,
                        $road->latitude,
                    ],
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }
}
