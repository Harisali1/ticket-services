<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\BankDetail;
use App\Models\Admin\Booking;
use App\Models\Admin\Notification;
use App\Models\User;
use App\Models\Admin\Agency;

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

        $bookingCounts = Booking::selectRaw("
                            COUNT(*) as total,
                            SUM(status = 1) as created,
                            SUM(status = 2) as ticketed,
                            SUM(status = 5) as cancelled");

        $todayReservation = Booking::query();
        
        if(auth()->user()->user_type_id != 1){
            $todayReservation = $todayReservation->where('created_by', auth()->user()->id);
            $bookingCounts = $bookingCounts->where('created_by', auth()->user()->id);
        }
        $todayReservation = $todayReservation->whereBetween('created_at', [$startDate,$endDate])->get();
        $bookingCounts = $bookingCounts->first();
        $bankDetails = BankDetail::where('status', 1)->get();
        $notifications = Notification::where('status', 1)->where('is_deleted', 0)->get();
        return view('Admin.dashboard', compact('bankDetails', 'todayReservation', 'notifications', 'bookingCounts'));
    }
}
