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
                'status'    => 3,
                'paid_by'   => auth()->user()->id,
                'paid_at'   => date('Y-m-d H:i:s'),
            ]);

            PaymentUpload::create([
                'booking_ids' => $request->booking_ids,
                'amount'    => $request->amount, 
                'image'     => $imagePath,
                'created_by' => auth()->user()->id,
                'paid_at'   => date('Y-m-d H:i:s'),
            ]);

            Booking::whereIn('id', $bookingIds)->update([
                'status' => 3,
                'paid_by'   => auth()->user()->id,
                'paid_at'   => date('Y-m-d H:i:s'),
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

    public function approvedPayment($id){
        // $paymentUploads = PaymentUpload::where('id', $id)->first();
        // $bookingIds = json_decode($paymentUploads->booking_ids);

        // PaymentUpload::find($id)->update([
        //     'approved_by' => auth()->user()->id
        // ]);
        
        // $payments = Payment::whereIn('booking_id', $bookingIds)->update([
        //     'approved_at' => date('Y-m-d H:i:s'),
        //     'is_approved' => 1,
        // ]);


        DB::beginTransaction();

        try {

            $paymentUpload = PaymentUpload::findOrFail($id);

            $bookingIds = json_decode($paymentUpload->booking_ids, true);

            if (empty($bookingIds) || !is_array($bookingIds)) {
                throw new \Exception('Invalid booking IDs.');
            }

            // Update payment upload
            $paymentUpload->update([
                'approved_by' => auth()->user()->id,
            ]);

            // Update payments
            $payments = Payment::whereIn('booking_id', $bookingIds)->update([
                'approved_at' => now(),
                'is_approved' => 1,
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Payment approved successfully.',
                'updated' => $payments
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Payment approval failed', [
                'payment_upload_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
