<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
     public function index(){
        return view('Admin.settings.add');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|confirmed|min:6',
        ]);

        /* Update Logo */
        if ($request->hasFile('logo')) {
            if ($user->logo && Storage::exists($user->logo)) {
                Storage::delete($user->logo);
            }

            $path = $request->file('logo')->store('logo', 'public');
            $user->logo = $path;
        }

        /* Update Password */
        if ($request->password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 422);
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully'
        ]);
    }
}
