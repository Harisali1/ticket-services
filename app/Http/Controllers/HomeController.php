<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\BankDetail;
use App\Models\Admin\Booking;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');
        $todayReservation = Booking::where('created_by', auth()->user()->id)->whereBetween('created_at', [$startDate,$endDate])->get();
        $bankDetails = BankDetail::where('status', 1)->where('created_by', auth()->user()->id)->get();
        return view('Admin.dashboard', compact('bankDetails', 'todayReservation'));
    }
}
