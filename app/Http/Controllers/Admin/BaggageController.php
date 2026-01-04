<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Baggage;
use Illuminate\Support\Facades\Validator;

class BaggageController extends Controller
{
    public function index(){
        return view('Admin.baggage.index');
    }

    public function create(){
        return view('Admin.baggage.add');
    }

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Save data
        $baggage = Baggage::create([
            'name' => $request->title,
            'price' => $request->price,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Baggage created successfully'
        ], 200);
    }

}
