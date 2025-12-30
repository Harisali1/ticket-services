<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Airport;

class AirportController extends Controller
{
    public function index(){
        return view('Admin.airport.list');
    }

    public function create(){
        return view('Admin.airport.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
        ]);

        Airport::create([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
        ]);

         return response()->json([
                'success' => true,
                'message' => 'AirPort created successfully',
            ], 201);
    }


    public function edit(Airport $airport){
        return view('Admin.airport.edit', compact('airport'));
    }

    public function update(Request $request){

        Airport::find($request->id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status1,
        ]);

         return response()->json([
                'success' => true,
                'message' => 'AirPort updated successfully',
            ], 201);
    }
}
