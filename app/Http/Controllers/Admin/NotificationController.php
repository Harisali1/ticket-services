<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Notification;

class NotificationController extends Controller
{
    public function index(){
        return view('Admin.notification.list');
    }

    public function create(){
        return view('Admin.notification.add');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        Notification::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

         return response()->json([
                'success' => true,
                'message' => 'Notification created successfully',
            ], 201);
    }

    public function edit(Notification $notification){
        return view('Admin.notification.edit', compact('notification'));
    }

    public function update(Request $request){

        Notification::find($request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

         return response()->json([
                'success' => true,
                'message' => 'Notification updated successfully',
            ], 201);
    }

}
