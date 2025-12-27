<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Airport;
use App\Models\Admin\Pnr;

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
}
