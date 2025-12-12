<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AirLineController extends Controller
{
    public function index(){
        return view('Admin.airline.list');
    }

    public function create(){
        return view('Admin.airline.add');
    }
}
