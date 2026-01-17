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

        $seatSum = array_sum($request->seat);
        $fareDetails = [];
        $pnrBookings = Pnr::with('departure','arrival','airline','seats','user')->find($request->pnr_id);
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
            ->where('passenger_type_id', $typeId)->first();

            if (!$passenger) {
                continue;
            }

            $baseFare = ($passenger->passenger_type_id == 1) ? $pnrBookings->base_price : $passenger->price;
            $taxes = ($pnrBookings->pnr_type != 'one_way') ? 200 : 100;

            if($pnrBookings->pnr_type == 'return' || $pnrBookings->pnr_type == 'open_jaw'){
                $rowTotal = ($baseFare + $pnrBookings->return_base_price) * $seatCount + $taxes;
                $totalFareAmount = ($baseFare+$pnrBookings->return_base_price) * $seatCount;
            }else{
                $rowTotal = $baseFare * $seatCount + $taxes;  
                $totalFareAmount = $baseFare * $seatCount;
            }

            $fareDetails[] = [
                'type_id'           => $passenger->passenger_type_id,
                'title'             => $passenger->title,
                'base_fare'         => $baseFare,
                'return_base_fare'  => $pnrBookings->return_base_price, 
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

        return view('Admin.booking.create-booking', compact('pnrBookings', 'data', 'fareDetails', 'seatSum', 'agency'));
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
            $bookingSeats = $request->booking_seats;

            foreach ($request->fareDetails as $type) {
                if ((int)$type['type_id'] === 3) {
                    $bookingSeats--;
                    break; // sirf 1 infant pe 1 seat kam
                }
            }

            $pnrBookings = Pnr::with('departure','arrival','airline','seats','user')->find($request->pnr_id);
            
            $seatIds = $pnrBookings->seats()
                        ->where('is_sale', 1)
                        ->orderBy('id') // important
                        ->limit($bookingSeats)
                        ->pluck('id');

            Seat::whereIn('id', $seatIds)->update([
                'is_sale' => 0,
                'is_sold' => 1
            ]);

            $bookingId = DB::table('bookings')->orderBy('id', 'desc')->value('id');
            $bookingData = [
                'pnr_id' => $request->pnr_id,
                'booking_no' => 'BK-0000'.$bookingId,
                'seats' => $bookingSeats,
                'price' => $request->total_fare,
                'tax' => $request->total_tax,
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

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $request->total_amount,
                'created_by' => auth()->user()->id,
            ]);

            foreach($request->fareDetails as $type){
                if($type['type_id'] != 3){
                    BookingPassenger::create([
                        'pnr_id' => $request->pnr_id,
                        'booking_id' => $booking->id,
                        'passenger_type_id' => $type['type_id'],
                        'seat' => $type['seat'],
                    ]);
                }
            }
            
            DB::commit();

            return redirect()->route('admin.booking.details',[
                'booking' => $booking->id,
                'pnr' => $request->pnr_id
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
        
        $bookingData = Booking::with('pnr', 'pnr.departure', 'pnr.arrival', 'pnr.return_departure', 'pnr.return_arrival', 'pnr.airline', 'pnr.return_airline', 'user')->find($bookingId);
        $response['booking'] = $bookingData->toArray();
        $response['customers'] = Customer::where('customers.booking_id', $bookingId)
        ->get(['customers.name', 'customers.phone_no', 'customers.dob']);

        // dd($response);
        $pdf = PDF::loadView('Admin/print/itinerary', $response);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('my-pdf.pdf');
    }

    public function bookingDetails($bookingId, $pnrId){

        $booking = Booking::with('pnr', 'pnr.airline')->find($bookingId);
        $customers = Customer::where('booking_id', $bookingId)->get();
        $pnr = Pnr::find($pnrId);
        $fareRules = FareRule::all();
        return view('Admin.booking.detail-booking', compact('booking', 'pnr', 'fareRules', 'customers'));
    }

    public function ticketedBooking(Request $request){

        $booking = Booking::with('pnr', 'pnr.airline', 'pnr.return_airline')->find($request->id);
        $customers = Customer::where('booking_id', $request->id)->get();
        $pnr = Pnr::find($booking->pnr_id);
        $fareRules = FareRule::all();

        $updateData = [];
        $airlinePrefix=0;
        
        if($booking->pnr->pnr_type != 'one_way'){
            $departureAirlinePrefix = $booking->pnr->airline->awb_prefix;
            $arrivalAirlinePrefix = $booking->pnr->return_airline->awb_prefix;

            $departureTicketNumber = $departureAirlinePrefix . mt_rand(1000000000, 9999999999);
            $arrivalTicketNumber = $arrivalAirlinePrefix . mt_rand(1000000000, 9999999999);

            if($request->status == 'ticket'){
                $updateData = [
                    'status' => 2,
                    'dept_ticket_no' =>  $departureTicketNumber,
                    'arr_ticket_no' => $arrivalTicketNumber,
                ];
            }
        }else{
            $departureAirlinePrefix = $booking->pnr->airline->awb_prefix;
            $departureTicketNumber = $departureAirlinePrefix . mt_rand(1000000000, 9999999999);
            if($request->status == 'ticket'){
                $updateData = [
                    'status' => 2,
                    'dept_ticket_no' =>  $departureTicketNumber,
                ];
            }
        }

        if($request->status == 'cancel'){
            $updateData = [
                'status' => 5
            ]; 
        }

        Booking::where('id', $request->id)->update($updateData);
        
        return view('Admin.booking.detail-booking', compact('booking', 'pnr', 'fareRules', 'customers'));

    }

    public function printTicketed($bookingId,$type){

        $bookingData = Booking::with('pnr', 'pnr.departure', 'pnr.arrival', 'pnr.return_departure', 'pnr.return_arrival', 'pnr.airline', 'pnr.return_airline', 'user')->find($bookingId);
        $response['booking'] = $bookingData->toArray();
        $response['customers'] = Customer::where('customers.booking_id', $bookingId)
        ->get(['customers.name', 'customers.phone_no', 'customers.dob']);
        $response['type'] = $type;

        $pdf = PDF::loadView('Admin/print/ticketed', $response);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('my-pdf.pdf');
        
    }

    public function sendEmailTicketed($bookingId,$type){

        $bookingData = Booking::with('pnr', 'pnr.departure', 'pnr.arrival', 'pnr.return_departure', 'pnr.return_arrival', 'pnr.airline', 'pnr.return_airline', 'user')->find($bookingId);
        $response['booking'] = $bookingData->toArray();
        $response['customers'] = Customer::where('customers.booking_id', $bookingId)
        ->get(['customers.name', 'customers.phone_no', 'customers.dob']);
        $response['type'] = $type;

        $pdf = PDF::loadView('Admin/print/ticketed', $response);
        $pdf->setPaper('A4', 'portrait');

        Mail::send('Admin.email_template.check', ['data' => 6871007], function ($message) use ($pdf) {
            $message->to('noreply@agency.divinetravel.it')
                ->subject('Notice of Delivery - Order# 6871007')
                ->attachData($pdf->output(), 'ticket.pdf');
        });
        
    }
}
