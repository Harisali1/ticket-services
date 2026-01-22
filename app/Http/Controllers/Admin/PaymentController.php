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

    public function create(){
        
        $totalRemain   = (int)auth()->user()->remaining_balance;
        $remainBal     = (int)auth()->user()->remain_balance;
        $paidBal       = (int)auth()->user()->paid_balance;
        $onApprovalBal = (int)auth()->user()->on_approval_balance;
        $partialBalance = (int)auth()->user()->partial_balance;

        return view('Admin.payment.add', compact(
            'totalRemain',
            'remainBal',
            'paidBal',
            'onApprovalBal',
            'partialBalance'
        ));
        return view('Admin.payment.add');
    }

    public function store(Request $request){

        $totalRemain   = (int)auth()->user()->remaining_balance;
        $remainBal     = (int)auth()->user()->remain_balance;
        $paidBal       = (int)auth()->user()->paid_balance;
        $onApprovalBal = (int)auth()->user()->on_approval_balance;
        $partialBalance = (int)auth()->user()->partial_balance;

        if($remainBal > 0){
            $remainBal = $remainBal;    
        }else{
            $remainBal = $totalRemain - $partialBalance;
        }
        if((int)$request->amount == 0){
            return response()->json([
                'code'    => 2,
                'success' => true,
                'message' => 'Please entered at least some amount',
            ], 201);
        }

        if($remainBal < (int)$request->amount){
            return response()->json([
                'code'    => 2,
                'success' => true,
                'message' => 'You entered amount greater then remaining balance',
            ], 201);
        }

        DB::beginTransaction();

        try {

            $bookingIds = Booking::where('created_by', auth()->id())
                        ->where('is_approved', 0)
                        ->whereIn('status', [2, 3])
                        ->get([DB::raw("CASE WHEN payment_status = 2 THEN partial_pay_amount ELSE total_amount END as partial_amount"),'id','total_amount'])
                        ->toArray();
            
        
            $paidAmount = (float) $request->amount;
            $paidBookings = [];

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('payments', 'public');
            }
                           
            foreach ($bookingIds as $bookingId => $bookings) {
                $bookingAmount = $bookings['total_amount'] - $bookings['partial_amount'];
                // agar paisay khatam ho gaye
                if ($paidAmount <= 0) {
                    break;
                }
                // FULL PAYMENT CASE
                if ($paidAmount >= $bookingAmount) {
                    $paidBookings[$bookings['id']] =[];
                    Booking::where('id', $bookings['id'])->update([
                        'paid_amount'    => $bookingAmount,
                        'payment_status'=> 3,
                        'status' => 3,
                        'paid_by'   => auth()->user()->id,
                        'paid_at'   => date('Y-m-d H:i:s'),
                    ]);
                    $paidAmount -= $bookingAmount;
                }
                // PARTIAL PAYMENT CASE
                else {
                    $paidBookings[$bookings['id']] =[];
                    Booking::where('id', $bookings['id'])->update([
                        'partial_pay_amount' => $paidAmount,
                        'payment_status'=> 2,
                        'paid_by'   => auth()->user()->id,
                        'paid_at'   => date('Y-m-d H:i:s'),
                    ]);
                    $paidAmount = 0;
                }
            }

            PaymentUpload::create([
                'booking_ids' => json_encode(array_keys($paidBookings)),
                'amount'    => $request->amount, 
                'image'     => $imagePath,
                'created_by' => auth()->user()->id,
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

    public function agencyPaymentApproval($id){
        return view('Admin.payment.payment_approval_list', compact('id'));
    }

    public function approvedPayment($id){
       
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
            $payments = Booking::where('payment_status', 3)->whereIn('id', $bookingIds)->update([
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

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
