<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Admin\Customer;
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
                'user_type_id' => 3,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'phone_no'  => $validated['phone_no'],
                'password'  => bcrypt($validated['password']),
                'status'    => $validated['status']
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

        DB::beginTransaction();

        try {

            User::find($request->id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone_no'  => $request->phone_no,
                'status'    => $request->status,
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

    public function customerUpdate(Request $request, $id){
        $passenger = Customer::findOrFail($id);

        $passenger->update([
            'name'              => $request->name,
            'surname'           => $request->surname,
            'dob'               => $request->dob,
            'gender'            => $request->gender,
            'email'             => $request->email,
            'phone_no'          => $request->phone_no,
            'passport_country'  => $request->passport_country,
            'passport_number'   => $request->passport_number,
            'nationality'       => $request->nationality,
            'expiry_date'       => $request->expiry_date,
        ]);

        // dd($passenger);
        return response()->json([
            'status' => true,
            'message' => 'Passenger updated successfully'
        ]);
    }

}
