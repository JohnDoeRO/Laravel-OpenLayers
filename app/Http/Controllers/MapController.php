<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Coords;

class MapController extends Controller
{

    public function index()
    {
        $data = Coords::all();
        return view('map')->with(compact('data'));
    }
    public function save(Request $request)
    {
        $coords = new Coords;
        $coords->lat = $request->latitude;
        $coords->lot = $request->longitude;
        $coords->save();

    }
}
