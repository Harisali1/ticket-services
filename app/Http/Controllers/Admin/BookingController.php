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
use DB;
use PDF;

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
        $totalAmount = 0;
        $fareDetails = [];

        foreach($request->passenger_type as $index => $typeId){
            $seatCount = (int) $request->seat[$index];
            $passenger = PassengerType::join('pnr_passengers', 'pnr_passengers.passenger_type_id', '=', 'passenger_types.id')
            ->where('passenger_type_id', $typeId)->first();

            if (!$passenger) {
                continue;
            }
            $rowTotal = $passenger->price * $seatCount + 200;
            $fareDetails[] = [
                'type_id'    => $passenger->passenger_type_id,
                'title'      => $passenger->title,
                'price'      => $passenger->price,
                'tax'        => 200,
                'seat'       => $seatCount,
                'row_total'  => $rowTotal,
            ];
            $totalAmount += $rowTotal;
        }

        $data = $request->all();
        $pnrBookings = Pnr::with('departure','arrival','airline','seats','user')->find($request->pnr_id);
        
        return view('Admin.booking.create-booking', compact('pnrBookings', 'data', 'fareDetails', 'totalAmount', 'seatSum'));
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

            $pnrBookings = Pnr::with('departure','arrival','airline','seats','user')->find($request->pnr_id);
            
            $seatIds = $pnrBookings->seats()
                        ->where('is_sale', 1)
                        ->orderBy('id') // important
                        ->limit($request->seats)
                        ->pluck('id');

            Seat::whereIn('id', $seatIds)->update([
                'is_sale' => 0,
                'is_sold' => 1
            ]);

            $bookingId = DB::table('bookings')->orderBy('id', 'desc')->value('id');
            $bookingData = [
                'pnr_id' => $request->pnr_id,
                'booking_no' => 'BK-0000'.$bookingId,
                'seats' => $request->seats,
                'price' => $request->total_price,
                'status' => 1
            ];

            $booking = Booking::create($bookingData);

            $customerData =[];
            foreach ($request->customer_name as $key => $i) {
                $customerData = [
                    'booking_id' => $booking->id,
                    'name_prefix' => $request->customer_prefix[$key],
                    'name' => $request->customer_name[$key],
                    'surname' => $request->customer_surname[$key],
                    'gender' => $request->customer_gender[$key],
                    'email' => $request->customer_email[$key],
                    'phone_no' => $request->customer_phone[$key],
                    'dob' => $request->customer_dob[$key],
                    'address' => $request->customer_address[$key],
                    'postal_code' => $request->customer_postal_code[$key],
                    'passport_type' => $request->customer_passport_type[$key],
                    'passport_number' => $request->customer_passport_number[$key],
                    'nationality' => $request->customer_nationality[$key],
                    'expiry_date' => $request->customer_expiry_date[$key],
                ];
                Customer::create($customerData);
            }

            foreach($request->fareDetails as $type){
                BookingPassenger::create([
                    'pnr_id' => $request->pnr_id,
                    'booking_id' => $booking->id,
                    'passenger_type_id' => $type['type_id'],
                ]);
            }
            
            $bookingCustomer = Customer::where('booking_id', $booking->id)->get();
            $requestData = $request->all();

            DB::commit();
            return view('Admin.booking.detail-booking', 
                compact('pnrBookings', 'booking', 'bookingCustomer', 'requestData'))
                ->with('success', 'Booking has been created successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function itineraryPrint(){
        
        $pdf = PDF::loadView('Admin/print/itinerary');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('my-pdf.pdf');
    }

}
