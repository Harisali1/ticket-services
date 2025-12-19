<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\AirLine;

class AirLineController extends Controller
{
    public function index(){
        return view('Admin.airline.list');
    }

    public function create(){
        return view('Admin.airline.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('airlines', 'public');
        }

        Airline::create([
            'name' => $request->name,
            'code' => $request->code,
            'logo' => $logoPath,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.airline.index')
            ->with('success', 'Airline created successfully');
    }

    // public function show(Agency $agency){
    //     $agency = Agency::with('user')->find($agency->id);
    //     return view('Admin.agency.show', compact('agency'));
    // }

    public function edit(AirLine $airline){
        // $airline = AirLine::find($airline->id);
        return view('Admin.airline.edit', compact('airline'));
    }

    public function update(Request $request, Agency $agency){
        dd($request->all(), $agency);
    }
}
