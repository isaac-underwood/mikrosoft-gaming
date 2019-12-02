<?php

namespace App\Http\Middleware;

use Closure;
use App\Group;

class CheckIsGroupOwner
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
        $group = Group::find($request->id);
        if($request->user()->id == $group->owner_id)
        {
            //User is group owner
            return $next($request);
        }
        //User is not group owner
        $message = 'You cannot access this page as you are not the group owner.';        
        return redirect()->route('groups.index')->with('status', $message);
    }
}
