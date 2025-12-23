<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use DB;

class UserController extends Controller
{
    public function index(){
        return view('Admin.user.list');
    }

    public function create(){
        return view('Admin.user.add');
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

    public function edit(User $user){
        return view('Admin.user.edit', compact('user'));
    }

    public function update(Request $request){
        // $validated = $request->validated();

        DB::beginTransaction();

        try {

            User::find($request->id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone_no'  => $request->phone_no,
            ]);
           
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
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
