<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Membership\Membership;

class Protect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $membership)
    {
        $memberships = explode('|', $membership);

        $site_membership = Membership::first();
        
        $pass = false;
        
        foreach($memberships as $m){
            if($site_membership->name == $m){
                $pass = true;
                break;
            }
        } 

        if (!$pass){
            return redirect('/');
        }
        return $next($request);
    }
}
