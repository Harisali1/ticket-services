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
use App\Helpers\NotificationHelper;

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
        
        if((int)$request->amount <= 0){
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
            $bookingIds = json_decode($request->booking_ids, true);

            if (empty($bookingIds)) {
                return response()->json([
                    'code' => 2,
                    'message' => 'Please select at least one booking'
                ]);
            }

            $bookings = Booking::whereIn('id', $bookingIds)
                ->where('created_by', $user->id)
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
                $bookingRemaining = $bookingRemaining - $booking->admin_fee;
                // 🔹 FULL PAYMENT
                if ($remainingAmount >= $bookingRemaining) {

                    $booking->update([
                        'paid_amount'        => $booking->total_amount-$booking->admin_fee,
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
            $paymentUpload = PaymentUpload::create([
                'slip_no'     => mt_rand(1000000000, 9999999999),
                'booking_ids' => json_encode($paidBookings),
                'amount'      => $usedAmount,
                'image'       => $imagePath,
                'created_by'  => $user->id,
                'paid_at'     => now(),
            ]);

            $name = auth()->user()->agency->name;
            NotificationHelper::notifyAdmins([
                'type' => 'payment',
                'title' => 'New Payment Created',
                'message' => "Payment slip no#{$paymentUpload->slip_no} created by agency {$name}",
                'url' => route('admin.agency.payment.approval', auth()->user()->id),
                'icon' => 'ticket'
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
                'is_approved' => 1,
                'approved_at' => date('Y-m-d H:i:s')
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

            $name = $user->agency->name;
            NotificationHelper::notifyAgency($user, [
                'type' => 'payment',
                'title' => 'Payment Approved',
                'message' => "Your payment slip no#{$paymentUpload->slip_no} approved by admin",
                'url' => route('admin.agency.payment.approval', auth()->user()->id),
                'icon' => 'ticket'
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

    public function paymentDeclined($id){

        DB::beginTransaction();

        try {
            $user = auth()->user();

            $paymentUploads = PaymentUpload::find($id);
            $user = User::find($paymentUploads->created_by);
            $paidAmount = $paymentUploads->amount;
            $bookingIds = json_decode($paymentUploads->booking_ids, true);
            $declinedAmount = 0;

            $bookings = Booking::whereIn('id', $bookingIds)
                ->where('created_by', $user->id)
                ->orderBy('id', 'asc')
                ->get();


            foreach ($bookings as $booking) {

                $bookingAmount = $booking->paid_amount != 0
                    ? $booking->paid_amount
                    : $booking->partial_pay_amount;

                if ($paidAmount >= $bookingAmount) {
                    // Full amount adjusted
                    $paidAmount -= $bookingAmount;

                    $booking->update([
                        'paid_amount'        => 0,
                        'partial_pay_amount' => 0,
                        'payment_status'     => 2,
                        'status'             => 2,
                        'paid_by'            => null,
                        'paid_at'            => null,
                    ]);

                } else {
                    // 🔥 Last booking – partial amount goes here
                    $booking->update([
                        'paid_amount'        => 0,
                        'partial_pay_amount' => $booking->paid_amount - $paidAmount,
                        'payment_status'     => 3,
                        'status'             => 2,
                    ]);

                    $paidAmount = 0;
                    break; // VERY IMPORTANT
                }
            }


            User::where('id', $user->id)->update([
                'on_approval_amount'     => $user->on_approval_amount - $paymentUploads->amount,
                'remaining_amount' => max(0, $user->remaining_amount + $paymentUploads->amount),
            ]);

            $paymentUploads->update([
                'is_cancel' => 1
            ]);
           
            $name = $user->agency->name;
            if(auth()->user()->user_type_id != 1){
                NotificationHelper::notifyAdmins([
                    'type' => 'payment',
                    'title' => 'Payment Declined',
                    'message' => "Payment slip no#{$paymentUploads->slip_no} has been Canceled by {$name}",
                    'url' => route('admin.payment.index'),
                    'icon' => 'money'
                ]);
            }else{
                NotificationHelper::notifyAgency($user, [
                    'type' => 'payment',
                    'title' => 'Payment Canceled',
                    'message' => "Your payment slip no#{$paymentUploads->slip_no} declined by admin",
                    'url' => route('admin.payment.index'),
                    'icon' => 'money'
                ]);
            }
             

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment Declined Successfully',
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
}
