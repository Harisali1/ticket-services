<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AgencyStoreRequest;
use App\Http\Requests\AgencyUpdateRequest;
use App\Models\Admin\Agency;
use App\Models\User;
use DB;

class AgencyController extends Controller
{
    public function index(){
        return view('Admin.agency.list');
    }

    public function create(){
        return view('Admin.agency.add');
    }

    public function store(AgencyStoreRequest $request){

        $validated = $request->validated();

        DB::beginTransaction();

        try {

            // Create User
            $user = User::create([
                'user_type_id' => 2,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'phone_no'  => $validated['phone_no'],
                'password'  => bcrypt($validated['password']),
            ]);

            // Create Agency
            $agency = Agency::create([
                'user_id'   => $user->id,
                'name'      => $validated['agency_name'],
                'piv'       => $validated['piv'],
                'address'   => $validated['agency_address'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agency created successfully',
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

    public function show(Agency $agency){
        $agency = Agency::with('user')->find($agency->id);
        return view('Admin.agency.show', compact('agency'));
    }

    public function edit(Agency $agency){
        $agency = Agency::with('user')->find($agency->id);
        return view('Admin.agency.edit', compact('agency'));
    }

    public function update(AgencyUpdateRequest $request){

        $validated = $request->validated();
            // dd($request->all());

        DB::beginTransaction();

        try {

            $agency = Agency::find($request->id);

            // Update User
            $user = User::find($agency->user_id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone_no'  => $request->phone_no,
            ]);
            
            // Update Agency
            $agency = Agency::find($request->id)->update([
                'user_id'   => $agency->user_id,
                'name'      => $request->agency_name,
                'piv'       => $request->piv,
                'address'   => $request->agency_address,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agency updated successfully',
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
