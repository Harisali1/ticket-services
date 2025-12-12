<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('Admin.user.list');
    }

    public function create(){
        return view('Admin.user.add');
    }
}
