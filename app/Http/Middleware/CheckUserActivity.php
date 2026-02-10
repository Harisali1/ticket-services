<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActivity
{
    public function handle($request, Closure $next)
    {
        $timeout = 600; // 10 minutes = 600 seconds

        if (Auth::check()) {

            if (session()->has('last_activity')) {

                $inactiveTime = time() - session('last_activity');

                if ($inactiveTime > $timeout) {
                    Auth::logout();
                    session()->flush();
                    return redirect('/login')->with('message','Session expired due to inactivity.');
                }
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
