<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use DB;

class PnrController extends Controller
{
    public function index(){
        return view('Admin.pnr.list');
    }

    public function create(){
        return view('Admin.pnr.add');
    }

    public function store(UserStoreRequest $request){

        $validated = $request->validated();

        DB::beginTransaction();

        try {

            $user = User::create([
                'user_type_id' => 1,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'phone_no'  => $validated['phone_no'],
                'password'  => bcrypt($validated['password']),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
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
}
