<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Ban;
use App\User;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check())
        {
            $ban_entry = Ban::where('user_id', auth()->user()->id)->where('banned_until', '>', now())->first();

            if ($ban_entry != null)
            {
                if ($ban_entry->banned_until && now()->lessThan($ban_entry->banned_until)) {
                    $banned_days = now()->diffInDays($ban_entry->banned_until);
                    auth()->logout();
        
                    if ($banned_days > 7) {
                        $message = 'Your account has been suspended indefinitely. Please contact administrator to appeal suspension.';
                    } else {
                        $message = 'Your account has been suspended for '.$banned_days.' '.str_plural('day', $banned_days).'. Please contact administrator to appeal suspension.';
                    }
        
                    return redirect()->route('login')->withMessage($message);
                    }
            }
            
        }
        
        return $next($request);
    }
}
