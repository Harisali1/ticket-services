<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'manage_agencies',
            'manage_airline',
            'manage_airport',
            'manage_user',
            'manage_pnr',
            'search_flight',
            'manage_booking',
            'bank_details',
            'payment',
            'notification',
            'edit_passengers',
            'edit_special_request',
            'pnr_ticketed',
            'requote',
            'void',
            'cancel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
        $user = User::find(1);
        $user->assignRole('admin');

        // $user->assignRole('admin');
        // $user->removeRole('admin');

        // $user->givePermissionTo('edit users');
        // $user->revokePermissionTo('edit users');

        // $user->hasRole('admin');
        // $user->can('edit users');

    }
}
