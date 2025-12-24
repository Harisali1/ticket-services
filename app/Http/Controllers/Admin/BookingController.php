<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(){
        return view('Admin.booking.list');
    }

    public function create(){
        return view('Admin.booking.add');
    }
}
