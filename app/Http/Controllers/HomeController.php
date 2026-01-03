<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\BankDetail;
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
        $bankDetails = BankDetail::where('status', 1)->where('created_by', auth()->user()->id)->get();
        return view('Admin.dashboard', compact('bankDetails'));
    }
}
