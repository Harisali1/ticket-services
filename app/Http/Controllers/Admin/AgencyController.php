<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AgencyStoreRequest;
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

            // Create Agency
            $agency = Agency::create([
                'name'     => $validated['agency_name'],
                'piv'             => $validated['piv'],
                'address'  => $validated['agency_address'],
            ]);

            // Create User
            $user = User::create([
                'user_type_id' => 2,
                'agency_id' => $agency->id,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'phone_no'  => $validated['phone_no'],
                'password'  => bcrypt($validated['password']),
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

    public function update(Request $request, Agency $agency){
        dd($request->all(), $agency);
    }
}
