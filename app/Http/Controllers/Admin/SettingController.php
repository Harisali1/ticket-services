<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Agency;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
     public function index(){
        return view('Admin.settings.add');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $agency = Agency::where('user_id', auth()->user()->id)->first();
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

        if($user){
            if($agency){
                $agency->update([
                    'admin_fee' => $request->admin_fee
                ]);
            }else{
                $user['admin_fee'] = $request->admin_fee;
            }
           
        }
        /* Update Password */
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 422);
            }

            $user->password = Hash::make($request->password);
            $user->show_pass = $request->password;
            $user->save();

            // 🔐 FORCE LOGOUT AFTER PASSWORD CHANGE
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'logout' => true,
                'message' => 'Password changed successfully. Please login again.'
            ]);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully'
        ]);
    }
}
