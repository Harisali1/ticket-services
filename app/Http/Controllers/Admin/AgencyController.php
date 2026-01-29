<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AgencyStoreRequest;
use App\Http\Requests\AgencyUpdateRequest;
use App\Models\Admin\Agency;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgencyCreationMail;
use App\Mail\AgencyApprovalMail;

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
        $status = 1;
        DB::beginTransaction();

        try {

            if(auth()->user()->user_type_id == 1 || auth()->user()->user_type_id == 3){
                $status = $request->status;
            }

            // Create User
            $user = User::create([
                'user_type_id' => (auth()->user()->user_type_id == 2) ? 4 : 2,
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'phone_no'  => $validated['phone_no'],
                'password'  => bcrypt($validated['password']),
                'show_pass' => $request->password,
                'status'    => $status,
                'created_by'=> auth()->user()->id,
            ]);

            // Create Agency
            $agency = Agency::create([
                'user_id'   => $user->id,
                'name'      => $validated['agency_name'],
                'piv'       => $validated['piv'],
                'show_pass' => $request->password,
                'address'   => $validated['agency_address'],
                'mark_up'   => (isset($request->mark_up)) ? $request->mark_up : null,
                'limit'     => (isset($request->limit)) ? $request->limit : null,
                'status'    => $status,
                'created_by'=> auth()->user()->id,
            ]);

            Mail::to($user->email)->send(new AgencyCreationMail($user, $agency));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agency created successfully and email send to agency.',
            ], 201);

        } catch (\Exception $e) {

            dd($e);
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

        DB::beginTransaction();

        try {

            $agency = Agency::find($request->id);
            $user = User::find($agency->user_id);
            $status = $agency->status;
            if(auth()->user()->user_type_id == 1 || auth()->user()->user_type_id == 3){
                $status = $request->status;
            }
            // Update User
            User::find($agency->user_id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone_no'  => $request->phone_no,
                'status'    => $status,
            ]);
            
            // Update Agency
            Agency::find($request->id)->update([
                'user_id'   => $agency->user_id,
                'name'      => $request->agency_name,
                'piv'       => $request->piv,
                'address'   => $request->agency_address,
                'mark_up'   => (isset($request->mark_up)) ? $request->mark_up : $agency->mark_up,
                'limit'     => (isset($request->limit)) ? $request->limit : null,
                'status'    => $status,
            ]);

            if($agency->status == 1 && $request->status == 2){
                Mail::to($request->email)->send(new AgencyApprovalMail($user, $agency));
            }

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

    public function PaymentList(){
        return view('Admin.agency.payment_list');
    }
}
