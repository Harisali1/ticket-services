<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;

class SettingController extends Controller
{
     public function index(){
        return view('Admin.settings.add');
    }

    public function store(Request $request){

        DB::beginTransaction();

        try {
            $logoPath = null;

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logo', 'public');
                User::where('id', auth()->user()->id)
                    ->update([
                        'logo' => $logoPath,
                    ]);
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Payment created successfully',
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
