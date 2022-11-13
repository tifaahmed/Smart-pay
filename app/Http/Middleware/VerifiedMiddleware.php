<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response ;

class VerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->phone_verified_at || Auth::user()->email_verified_at) {
            return $next($request);
        }
        else {
            return \Response::json( [
                'message'   => 'this acount not active.' ,
                'status'    => 'false.' ,
                'code'      => Response::HTTP_BAD_REQUEST           ,
            ] + [] , Response::HTTP_BAD_REQUEST);
        }     
    }
}
