<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function index(){
        return view('Admin.role.list');
    }

    public function create(){
        return view('Admin.role.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.role.index')->with(['message' => 'Role created successfully']);
    }


    public function edit(Airport $airport){
        return view('Admin.role.edit', compact('airport'));
    }

    public function update(Request $request){

        Airport::find($request->id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status1,
        ]);

         return response()->json([
                'success' => true,
                'message' => 'AirPort updated successfully',
            ], 201);
    }

    public function rolePermission($id)
    {
        $permissions = Permission::all();
        $user = User::findOrFail($id);

        // user ka pehla role (agar multiple nahi use kar rahe)
        $role = $user->roles->first();

        // user ki current permissions
        $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();

        return view(
            'Admin.role.role_permission',
            compact('permissions', 'user', 'role', 'userPermissions')
        );
    }


    // public function rolePermissionStore(Request $request){
    //     $role = Role::firstOrCreate(['name' => $request->name]);

    //     $user = User::find($request->user_id);
    //     $user->assignRole($request->name);
    //     // $user->removeRole($request->role_name);
    //     $role->givePermissionTo($request->permissions);
    //     // $role->revokePermissionTo('edit users');
    //     return redirect()->route('admin.agency.index');
    // }

    public function rolePermissionStore(Request $request){
        $role = Role::firstOrCreate(['name' => $request->name]);

        // role ki permissions sync karo
        $role->syncPermissions($request->permissions ?? []);

        $user = User::findOrFail($request->user_id);

        // purana role remove + naya assign
        $user->syncRoles([$role->name]);

        return redirect()
            ->route('admin.agency.index')
            ->with('success', 'Role & permissions updated successfully');
    }

}
