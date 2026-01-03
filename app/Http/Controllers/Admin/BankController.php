<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BankDetail;

class BankController extends Controller
{
    public function create(){
        return view('Admin.bank.add');
    }

    public function store(Request $request){
        try {

            // ✅ Validation
            $validated = $request->validate([
                'bank_name' => 'required|string|max:255',
                'ac_title'  => 'required|string|max:255',
                'ac_no'     => 'required|string|max:255',
                'branch'    => 'required|string|max:255',
                'iban'      => 'required|string|max:255',
                'status'    => 'required|in:0,1',
            ]);

            // ✅ Insert into DB
            BankDetail::create([
                'bank_name' => $validated['bank_name'],
                'ac_title'  => $validated['ac_title'],
                'ac_no'     => $validated['ac_no'],
                'branch'    => $validated['branch'],
                'iban'      => $validated['iban'],
                'status'    => $validated['status'],
                'created_by'=> auth()->user()->id,
            ]);

            // ✅ Success response (AJAX)
            return response()->json([
                'status'  => true,
                'message' => 'Bank details saved successfully.'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => $e->validator->errors()->first()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
