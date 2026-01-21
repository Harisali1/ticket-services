<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Notification;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'required', 'file', 'mimes:png,jpg,jpeg', 'max:5120'
        ]);

         $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notification', 'public');
        }

        Notification::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imagePath
        ]);

         return response()->json([
                'success' => true,
                'message' => 'Notification created successfully',
            ], 201);
    }

    public function edit(Notification $notification){
        return view('Admin.notification.edit', compact('notification'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'required|in:1,2',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $notificaiton = Notification::find($request->id);

        if ($request->hasFile('image')) {
            // Delete old logo if exists
            if ($notificaiton->image && Storage::disk('public')->exists($notificaiton->image)) {
                Storage::disk('public')->delete($notificaiton->image);
            }
            // Store new logo
            $imagePath = $request->file('image')->store('notification', 'public');
        }else{
            $imagePath = $notificaiton->image;
        }

        Notification::find($request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imagePath
        ]);
        
        return response()->json([
            'message' => 'Notification updated successfully'
        ]);
    }

    public function delete($id){
       Notification::find($id)->update([
            'is_deleted' => 1
       ]);
       return response()->json([
            'message' => 'Notification updated successfully'
        ]);
    }

}
