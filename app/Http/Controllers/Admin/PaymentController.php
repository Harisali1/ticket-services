<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Payment;
use App\Models\Admin\PaymentUpload;
use App\Models\Admin\Booking;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentApprovedMail;

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

        $totalRemain   = (int)auth()->user()->ticketed_amount;
        
        if((int)$request->amount == 0){
            return response()->json([
                'code'    => 2,
                'success' => true,
                'message' => 'Please entered at least some amount',
            ], 201);
        }

        if($totalRemain < (int)$request->amount){
            return response()->json([
                'code'    => 2,
                'success' => true,
                'message' => 'You entered amount greater then remaining balance',
            ], 201);
        }


        DB::beginTransaction();

        try {

            $user = auth()->user();

            $postedAmount = (int) $request->amount;
            $remainingAmount = $postedAmount;

            $paidBookings = [];

            // 🔹 Get unpaid / partial bookings (FIFO)
            $bookings = Booking::where('created_by', $user->id)
                ->where('is_approved', 0)
                ->whereIn('status', [2]) // ticketed / unpaid
                ->orderBy('id', 'asc')
                ->get();

            // 🔹 Upload payment image
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('payments', 'public');
            }

            foreach ($bookings as $booking) {

                if ($remainingAmount <= 0) {
                    break;
                }

                // Remaining amount for this booking
                $bookingRemaining = $booking->total_amount - $booking->partial_pay_amount;

                // 🔹 FULL PAYMENT
                if ($remainingAmount >= $bookingRemaining) {

                    $booking->update([
                        'paid_amount'        => $booking->total_amount,
                        'partial_pay_amount' => 0,
                        'payment_status'     => 3, // paid
                        'status'             => 3, // fully paid
                        'paid_by'            => $user->id,
                        'paid_at'            => now(),
                    ]);

                    $remainingAmount -= $bookingRemaining;
                }

                // 🔹 PARTIAL PAYMENT
                else {

                    $booking->update([
                        'partial_pay_amount' => $booking->partial_pay_amount + $remainingAmount,
                        'payment_status'     => 3, // money received
                        'paid_by'            => $user->id,
                        'paid_at'            => now(),
                    ]);

                    $remainingAmount = 0;
                }

                $paidBookings[] = $booking->id;
            }

            // 🔹 ACTUAL amount used (important)
            $usedAmount = $postedAmount - $remainingAmount;

            // 🔹 Update auth user wallet
            User::where('id', $user->id)->update([
                'on_approval_amount'     => $user->on_approval_amount + $usedAmount,
                'remaining_amount' => max(0, $user->remaining_amount - $usedAmount),
            ]);

            // 🔹 Save payment history
            PaymentUpload::create([
                'booking_ids' => json_encode($paidBookings),
                'amount'      => $usedAmount,
                'image'       => $imagePath,
                'created_by'  => $user->id,
                'paid_at'     => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment adjusted successfully',
                'used_amount' => $usedAmount,
                'remaining_amount' => $remainingAmount
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
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
                'is_approved' => 1
            ]);

            // Update payments
            $payments = Booking::where('status', 3)->whereIn('id', $bookingIds)->update([
                'approved_at' => now(),
                'approved_by' => auth()->user()->id,
                'is_approved' => 1,
            ]);

            $user = User::find($paymentUpload->created_by);
            User::where('id', $user->id)->update([
                'on_approval_amount'     => $user->on_approval_amount - $paymentUpload->amount,
                'paid_amount' => $user->paid_amount + $paymentUpload->amount,
            ]);
            Mail::to($user->email)->send(new PaymentApprovedMail($user, $paymentUpload->amount, $paymentUpload->amount, $user->remaining_amount));

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
