<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Payment;
use App\Models\Admin\PaymentUpload;
use App\Models\Admin\Booking;
use DB;

class PaymentController extends Controller
{
    public function index(){
        return view('Admin.payment.list');
    }

    public function store(Request $request){

        $bookingIds = json_decode($request->booking_ids, true);

        DB::beginTransaction();

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('payments', 'public');
            }

            $payments = Payment::whereIn('booking_id', $bookingIds)->update([
                'status'    => 2,
                'paid_by'   => auth()->user()->id,
                'paid_at'   => date('Y-m-d H:i:s'),
            ]);

            PaymentUpload::create([
                'amount'    => $request->amount, 
                'image'     => $imagePath,
                'created_by' => auth()->user()->id
            ]);

            Booking::whereIn('id', $bookingIds)->update([
                'status' => 3
            ]);

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
