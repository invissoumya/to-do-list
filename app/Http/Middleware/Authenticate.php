<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

     public function handle($request, Closure $next, ...$guards)
    {
        if(!auth()->user()){
            return response()->json(['You do not have permission to access for this page.']);
        }
    }

    
   
}
