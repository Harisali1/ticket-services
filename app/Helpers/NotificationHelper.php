<?php 

namespace App\Helpers;

use App\Models\User;
use App\Notifications\PortalNotification;

class NotificationHelper
{
    public static function notifyAdmins(array $data)
    {
        $admins = User::where('user_type_id', 1)->get();

        foreach ($admins as $admin) {
            $admin->notify(new PortalNotification($data));
        }
    }

    public static function notifyAllActiveUsers(array $data)
    {
        $users = User::where('status', 2)->where('user_type_id', '!=', 1)->get();

        foreach ($users as $user) {
            $user->notify(new PortalNotification($data));
        }
    }

    public static function notifyAgency(User $agency, array $data)
    {
        $agency->notify(new PortalNotification($data));
    }
}
