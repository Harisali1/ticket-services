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

    public function store(Request $request){
        $pnrBookings = Pnr::with('departure','arrival','airline','seats')->find($request->pnr_id);
        return view('admin.booking.create-booking', compact('pnrBookings'));
    }
}
