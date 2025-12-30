<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\AirLine;
use DB;
use App\Http\Requests\AirLineStoreRequest;
use App\Http\Requests\AirLineUpdateRequest;
use Illuminate\Support\Facades\Storage;

class AirLineController extends Controller
{
    public function index(){
        return view('Admin.airline.list');
    }

    public function create(){
        return view('Admin.airline.add');
    }

    public function store(AirLineStoreRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {

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

            DB::commit();

            return response()->json([
                    'success' => true,
                    'message' => 'AirLine created successfully',
                ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }        
    }


    public function edit(AirLine $airline){
        return view('Admin.airline.edit', compact('airline'));
    }

    public function update(AirLineUpdateRequest $request){

        $validated = $request->validated();

        DB::beginTransaction();

        try {

            $airline = AirLine::find($request->id);

            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($airline->logo && Storage::disk('public')->exists($airline->logo)) {
                    Storage::disk('public')->delete($airline->logo);
                }
                // Store new logo
                $logoPath = $request->file('logo')->store('airlines', 'public');
            }else{
                $logoPath = $airline->logo;
            }

            AirLine::find($request->id)->update([
                'name' => $request->name,
                'code' => $request->code,
                'status' => $request->status1,
                'logo' => $logoPath
            ]);

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'AirLine updated successfully',
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }

    }
}
