<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Airport;
use App\Models\Admin\Pnr;
use App\Models\Admin\Booking;
use App\Models\Admin\Customer;
use DB;

class BookingController extends Controller
{
    public function index(){
        return view('Admin.booking.list');
    }

    public function create(Request $request){
        $airports = Airport::where('status', 1)->get();

        if ($request->isMethod('post')) {

            return view('Admin.booking.add', [
                'airports' => $airports,
                'showPnrSearch' => $request->filled([
                    'departure_id',
                    'arrival_id',
                    'departure_date',
                    'arrival_date'
                ]),
                'initialFilters' => $request->only([
                    'departure_id',
                    'arrival_id',
                    'departure_date',
                    'arrival_date'
                ]),
            ]);
        }

        return view('Admin.booking.add', [
            'airports' => $airports,
            'showPnrSearch' => false,
            'initialFilters' => $request->all(),
        ]);
    }

    public function getPnrInfo(Request $request){
        $data = $request->all();
        $pnrBookings = Pnr::with('departure','arrival','airline','seats')->find($request->pnr_id);
        $seatsPrice = $pnrBookings->seats()->where('is_sale', 1)->limit($request->seat)->get()->sum('price');
        $data['total_seats_price'] = $seatsPrice;
        return view('admin.booking.create-booking', compact('pnrBookings', 'data'));
    }

    public function checkSeatsAvailability(Request $request){

        $pnr = Pnr::find($request->pnr_id);
        $availableSeats = $pnr->seats()->where('is_sale', 1)->count();
        if($availableSeats == 0){
            return response()->json([
                'code' => 2,
                'message' => 'Seats not available',
            ], 201);
        }
        elseif($availableSeats < $request->seat){
            return response()->json([
                'code' => 2,
                'message' => 'Your Seats must be less then available seats',
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
            foreach ($request->prefix as $key => $i) {
                $customerData = [
                    'booking_id' => $booking->id,
                    'name_prefix' => $i,
                    'name' => $request->name[$key],
                ];
                Customer::create($customerData);
            }

            DB::commit();

            return redirect()->route('admin.booking.index');

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
