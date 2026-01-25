<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Airport;
use App\Models\Admin\Pnr;
use App\Models\Admin\Booking;
use App\Models\Admin\Customer;
use App\Models\Admin\Seat;
use App\Models\Admin\PassengerType;
use App\Models\Admin\BookingPassenger;
use App\Models\Admin\FareRule;
use App\Models\Admin\Agency;
use App\Models\Admin\Payment;
use App\Models\Admin\PaymentUpload;
use App\Models\User;
use DB;
use PDF;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(){
        return view('Admin.booking.list');
    }

    public function create(Request $request){
        $airports = Airport::where('status', 1)->get();
        $passengerTypes = PassengerType::all();

        if ($request->isMethod('post')) {
            return view('Admin.booking.add', [
                'airports' => $airports,
                'showPnrSearch' => $request->all([
                    'trip_type',
                    'departure_id',
                    'arrival_id',
                    'departure_date',
                    'day_minus',
                    'day_plus',
                    'return_departure_id',
                    'return_arrival_id',
                    'return_departure_date',
                    'return_day_minus',
                    'return_day_plus'
                ]),
                'initialFilters' => $request->only([
                    'trip_type',
                    'departure_id',
                    'arrival_id',
                    'departure_date',
                    'day_minus',
                    'day_plus',
                    'return_departure_id',
                    'return_arrival_id',
                    'return_departure_date',
                    'return_day_minus',
                    'return_day_plus'
                ]),
            ]);
        }


        return view('Admin.booking.add', [
            'airports' => $airports,
            'showPnrSearch' => false,
            'initialFilters' => $request->all(),
            'passengerTypes' => $passengerTypes,
        ]);
    }

    public function getPnrInfo(Request $request){

        // dd($request->all());
        $seatSum = array_sum($request->seat);
        $fareDetails = [];
        $pnrBookings = Pnr::with('departure','arrival','airline','seats','user')->find($request->pnr_id);
        $returnPnrBookings = Pnr::with('departure','arrival','airline','seats','user')->find($request->return_pnr_id);
       
        $baseFare=0;
        $returnBaseFare=0;
        $taxes=0;
        $totalFareAmount=0;
        $totalAmount = 0;
        $totalBaseFareAmount=0;
        $totalTax=0;
       
        foreach($request->passenger_type as $index => $typeId){
            $seatCount = (int) $request->seat[$index];
            $passenger = PassengerType::join('pnr_passengers', 'pnr_passengers.passenger_type_id', '=', 'passenger_types.id')
            ->where('passenger_type_id', $typeId)
            ->where('pnr_id',$request->pnr_id)
            ->first();

            $returnPassenger = PassengerType::join('pnr_passengers', 'pnr_passengers.passenger_type_id', '=', 'passenger_types.id')
            ->where('passenger_type_id', $typeId)
            ->where('pnr_id',$request->return_pnr_id)
            ->first();

            if (!$passenger) {
                continue;
            }

            $baseFare = ($passenger->passenger_type_id == 1) ? $pnrBookings->base_price : $passenger->price;
            $taxes = ($request->return_pnr_id != null) ? 200 : 100;

            if($request->return_pnr_id != null){
                $returnBaseFare = ($returnPassenger->passenger_type_id == 1) ? $returnPnrBookings->base_price : $returnPassenger->price;
                $rowTotal = ($baseFare + $returnBaseFare) * $seatCount + $taxes;
                $totalFareAmount = ($baseFare+$returnBaseFare) * $seatCount;
            }else{
                $rowTotal = $baseFare * $seatCount + $taxes;  
                $totalFareAmount = $baseFare * $seatCount;
            }

            $fareDetails[] = [
                'type_id'           => $passenger->passenger_type_id,
                'title'             => $passenger->title,
                'base_fare'         => $baseFare,
                'return_base_fare'  => $pnrBookings->base_price, 
                'tax'               => $taxes,
                'seat'              => $seatCount,
                'total_fare_amount' => $totalFareAmount,
                'row_total'         => $rowTotal,
            ];
            $totalAmount += $rowTotal;
            $totalBaseFareAmount += $totalFareAmount;
            $totalTax += $taxes;

        }

        $data = $request->all();
        $data['totalAmount'] = $totalAmount;
        $data['totalBaseFareAmount'] = $totalBaseFareAmount;
        $data['totalTax'] = $totalTax;
        $agency = Agency::where('user_id', auth()->user()->id)->first();

        return view('Admin.booking.create-booking', compact('pnrBookings', 'data', 'fareDetails', 'seatSum', 'agency','returnPnrBookings'));
    }

    public function checkSeatsAvailability(Request $request){

        
        $seats = array_sum($request->seat);
        if($seats == 0){
            return response()->json([
                'code' => 2,
                'message' => 'You must be enter at least one seat',
            ], 201);
        }

        $pnr = Pnr::find($request->pnr_id);
        $availableSeats = $pnr->seats()->where('is_sale', 1)->count();

        if($request->return_pnr_id != null){
            $returnPnr = Pnr::find($request->return_pnr_id);
            $returnAvailableSeats = $returnPnr->seats()->where('is_sale', 1)->count();
            $availableSeats = min($availableSeats, $returnAvailableSeats);
        }

        if($availableSeats == 0){
            return response()->json([
                'code' => 2,
                'message' => 'Seats not available',
            ], 201);
        }
        elseif($availableSeats < $seats){
            return response()->json([
                'code' => 2,
                'message' => 'Your Seats must be less then or equal available seats',
            ], 201); 
        }else{
            return response()->json([
                'code' => 1,
            ], 200); 
        }
    }

    public function bookingSubmit(Request $request){

        DB::beginTransaction();
        try {
            $bookingSeats = 0;

            foreach ($request->fareDetails as $type) {
                $bookingSeats += $type['seat'];
            }

            $pnrBookings = Pnr::with('departure','arrival','airline','seats','user')->find($request->pnr_id);
            $returnPnrBookings = Pnr::with('departure','arrival','airline','seats','user')->find($request->return_pnr_id);
            
            $seatIds = $pnrBookings->seats()
                        ->where('is_sale', 1)
                        ->orderBy('id') // important
                        ->limit($bookingSeats)
                        ->pluck('id');

            Seat::whereIn('id', $seatIds)->update([
                'is_sale' => 0,
                'is_reserved' => 1
            ]);

            if($request->return_pnr_id != null){
                $seatIds = $returnPnrBookings->seats()
                            ->where('is_sale', 1)
                            ->orderBy('id') // important
                            ->limit($bookingSeats)
                            ->pluck('id');

                Seat::whereIn('id', $seatIds)->update([
                    'is_sale' => 0,
                    'is_reserved' => 1
                ]);
            }

            $bookingId = DB::table('bookings')->orderBy('id', 'desc')->value('id');
            $bookingData = [
                'pnr_id' => $request->pnr_id,
                'return_pnr_id' => ($request->return_pnr_id != null) ? $request->return_pnr_id : null, 
                'booking_no' => 'BK-0000'.$bookingId,
                'seats' => $bookingSeats,
                'price' => $request->total_fare,
                'tax' => $request->total_tax,
                'admin_fee' => $request->admin_fee,
                'total_amount' => $request->total_amount,
                'meal' => $request->meal,
                'wheel_chair' => $request->wheel_chair,
                'status' => 1,
                'created_by' => auth()->user()->id
            ];

            $booking = Booking::create($bookingData);

            $customerData =[];
            foreach ($request->customer_name as $key => $i) {
                $customerData = [
                    'booking_id' => $booking->id,
                    'country' => $request->customer_country[$key],
                    'city' => $request->customer_city[$key],
                    'name_prefix' => $request->customer_prefix[$key],
                    'name' => $request->customer_name[$key],
                    'surname' => $request->customer_surname[$key],
                    'gender' => $request->customer_gender[$key],
                    'email' => $request->customer_email[$key],
                    'phone_no' => $request->customer_phone[$key],
                    'dob' => $request->customer_dob[$key],
                    'address' => $request->customer_address[$key],
                    'postal_code' => $request->customer_postal_code[$key],
                    'passport_number' => $request->customer_passport_number[$key],
                    'passport_country' => $request->customer_passport_county[$key],
                    'nationality' => $request->customer_nationality[$key],
                    'expiry_date' => $request->customer_expiry_date[$key],
                ];
                Customer::create($customerData);
            }

            foreach($request->fareDetails as $type){
                BookingPassenger::create([
                    'pnr_id' => $request->pnr_id,
                    'return_pnr_id' => $request->return_pnr_id,
                    'booking_id' => $booking->id,
                    'passenger_type_id' => $type['type_id'],
                    'seat' => $type['seat'],
                ]);
            }

            $user = auth()->user();
            $updatedTotalAmount = $user->total_amount+$request->total_amount;
            User::find($user->id)->update([
                'total_amount' => $updatedTotalAmount
            ]);
            
            DB::commit();

            return redirect()->route('admin.booking.details',[
                'booking' => $booking->id,
                'pnr' => $request->pnr_id,
                'id' => $booking->return_pnr_id ?? 0
            ])->with('success', 'Booking created successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function itineraryPrint($bookingId){
        
        $bookingData = Booking::with('pnr', 'pnr.departure', 'pnr.arrival', 'pnr.airline', 'return_pnr.departure', 'return_pnr.arrival',  'return_pnr.airline', 'user')->find($bookingId);
        $response['booking'] = $bookingData->toArray();
        $response['customers'] = Customer::where('customers.booking_id', $bookingId)
        ->get(['customers.name', 'customers.phone_no', 'customers.dob', 'customers.surname', 'customers.email']);
        $response['agency'] = Agency::with('user')->where('user_id', $bookingData->created_by)->first();

        $pdf = PDF::loadView('Admin/print/itinerary', $response);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('my-pdf.pdf');
    }

    public function bookingDetails($bookingId, $pnrId, $returnPnrId){

        $booking = Booking::with('pnr', 'pnr.airline', 'return_pnr', 'return_pnr.airline')->find($bookingId);
        $customers = Customer::where('booking_id', $bookingId)->get();
        $pnr = Pnr::find($pnrId);
        $fareRules = FareRule::all();
        return view('Admin.booking.detail-booking', compact('booking', 'pnr', 'fareRules', 'customers'));
    }

    public function ticketedBooking(Request $request){
        $user = auth()->user();

        // 🔹 Limit check (only on ticket)
        if ($request->status === 'ticket') {

            $paymentAmount = Booking::where('created_by', $user->id)
                ->where('is_approved', 0)
                ->whereIn('status', [2, 3])
                ->sum('total_amount');

            if ($user->user_type_id != 1) {
                $agency = Agency::where('user_id', $user->id)->first();

                if ($paymentAmount > $agency->limit) {
                    return response()->json([
                        'code' => 2,
                        'message' => 'Your payable amount exceeds your limit',
                    ], 201);
                }
            }
        }

        DB::beginTransaction();

        try {

            $booking = Booking::with('pnr', 'pnr.airline', 'return_pnr', 'return_pnr.airline')
                ->findOrFail($request->id);

            $customers  = Customer::where('booking_id', $booking->id)->get();
            $fareRules  = FareRule::all();

            $updateData = [];

            // 🔹 Handle Ticket / Cancel
            if (in_array($request->status, ['ticket', 'cancel'])) {

                $statusValue = $request->status === 'ticket' ? 2 : 5;

                $updateData['status'] = $statusValue;

                // 🔹 Departure PNR
                $this->updateSeats(
                    $booking->pnr,
                    $booking->seats,
                    $request->status
                );

                if ($request->status === 'ticket') {
                    $updateData['dept_ticket_no'] = '055' . mt_rand(1000000000, 9999999999);
                }

                // 🔹 Return PNR (if exists)
                if ($booking->return_pnr_id) {

                    $this->updateSeats(
                        $booking->return_pnr,
                        $booking->seats,
                        $request->status
                    );

                    if ($request->status === 'ticket') {
                        $updateData['arr_ticket_no'] = '055' . mt_rand(1000000000, 9999999999);
                    }
                }
            }

            Booking::where('id', $booking->id)->update($updateData);

            if($request->status == 'ticket'){
                $booking = Booking::find($booking->id);
                $user = auth()->user();
                $updatedTicketedAmount = $user->ticketed_amount+$booking->total_amount;
                $updatedRemainingAmount = $user->remaining_amount+$booking->total_amount;
                User::find($user->id)->update([
                    'ticketed_amount' => $updatedTicketedAmount,
                    'remaining_amount' => $updatedRemainingAmount
                ]);
            }

            if($request->status == 'cancel'){
                $booking = Booking::find($booking->id);
                $user = auth()->user();
                $updatedTotalAmount = $user->total_amount-$booking->total_amount;
                User::find($user->id)->update([
                    'total_amount' => $updatedTotalAmount
                ]);
            }

            DB::commit();

            return view('Admin.booking.detail-booking', compact(
                'booking',
                'fareRules',
                'customers'
            ));

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    private function updateSeats($pnr, $seatCount, $action){
        
        $seatIds = $pnr->seats()
            ->where('is_reserved', 1)
            ->orderBy('id')
            ->limit((int) $seatCount)
            ->pluck('id');

        $data = match ($action) {
            'ticket' => ['is_reserved' => 0, 'is_sold' => 1],
            'cancel' => ['is_reserved' => 0, 'is_sale' => 1],
        };

        Seat::whereIn('id', $seatIds)->update($data);
    }

    public function printTicketed($bookingId,$type){

        $bookingData = Booking::with('pnr', 'pnr.departure', 'pnr.arrival', 'pnr.middle_arrival', 
        'return_pnr.departure', 'return_pnr.arrival', 'pnr.airline', 'return_pnr.airline', 'user')->find($bookingId);
        $response['booking'] = $bookingData->toArray();
        $response['customers'] = Customer::where('customers.booking_id', $bookingId)
        ->get(['customers.name', 'customers.phone_no', 'customers.dob', 'customers.surname']);
        $response['type'] = $type;
        $response['agency'] = Agency::with('user')->where('user_id', $bookingData->created_by)->first();

        $pdf = PDF::loadView('Admin/print/ticketed', $response);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('my-pdf.pdf');
        
    }

    public function sendEmailTicketed($bookingId,$type){

        $bookingData = Booking::with('pnr', 'pnr.departure', 'pnr.arrival', 'pnr.middle_arrival', 
        'return_pnr.departure', 'return_pnr.arrival', 'pnr.airline', 'return_pnr.airline', 'user')->find($bookingId);
        $response['booking'] = $bookingData->toArray();
        $response['customers'] = Customer::where('customers.booking_id', $bookingId)
        ->get(['customers.name', 'customers.phone_no', 'customers.dob', 'customers.email', 'customers.surname']);
        $response['type'] = $type;
        $response['agency'] = Agency::with('user')->where('user_id', $bookingData->created_by)->first();

        $pdf = PDF::loadView('Admin/print/ticketed', $response);
        $pdf->setPaper('A4', 'portrait');

        Mail::send('Admin.email_template.ticket_attachment', ['user'=>auth()->user()], function ($message) use ($pdf, $response, $bookingData) {
            $message->to($response['customers'][0]->email)
                ->subject('Ticket - Order#'. $bookingData->booking_no)
                ->attachData($pdf->output(), 'ticket.pdf');
        });

        return redirect()->route('admin.booking.details',[
                'booking' => $bookingData->id,
                'pnr' => $bookingData->pnr_id,
                'id' => $bookingData->return_pnr_id
            ])->with('success', 'email send successfully.');        
    }

    public function updateSpecialRequest(Request $request, $id){
        $booking = Booking::findOrFail($id);

        $request->validate([
            'meal'        => 'nullable|string|max:255',
            'wheel_chair' => 'nullable|string|max:255',
        ]);

        $booking->update([
            'meal'        => $request->meal,
            'wheel_chair' => $request->wheel_chair,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Special request updated successfully'
        ]);
    }

    public function voidBooking($id){
        
        DB::beginTransaction();

        try{
            $booking = Booking::find($id);
            $seatLimit = $booking->seats;

            Booking::find($id)->update([
                'status' => 4
            ]);
            
            if($booking->return_pnr_id != null){
                $seats = Seat::where('pnr_id', $booking->return_pnr_id)
                                ->where('is_sold', 1)
                                ->orderBy('id', 'DESC')
                                ->limit((int)$seatLimit)
                                ->pluck('id');

                Seat::whereIn('id', $seats)->update([
                    'is_sold' => 0,
                    'is_sale' => 1
                ]);
            }

            $seats = Seat::where('pnr_id', $booking->pnr_id)
                            ->where('is_sold', 1)
                            ->orderBy('id', 'DESC')
                            ->limit((int)$seatLimit)
                            ->pluck('id');

            Seat::whereIn('id', $seats)->update([
                'is_sold' => 0,
                'is_sale' => 1
            ]);
        
        DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'successfully void this booking'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function reQuoteBooking($id){

        $booking = Booking::find($id);
        $pnr = Pnr::find($booking->pnr_id);

        $baseFare=$pnr->base_price;
        $tax=$pnr->tax;
        $total=$pnr->total;

        if($booking->return_pnr_id != null){
            $returnPnr = Pnr::find($booking->return_pnr_id);
            $baseFare+=$returnPnr->base_price;
            $tax+=$returnPnr->tax;
            $total+=$returnPnr->total;
        }

        Booking::find($id)->update([
            'price' => $baseFare,
            'tax' => $tax,
            'total_amount' => $total,
        ]);
        
        return response()->json([
            'status'  => true,
            'message' => 'successfully requote this booking.'
        ]);

    }
}
