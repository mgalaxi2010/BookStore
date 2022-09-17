<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // get token
        $access_token = $request->bearerToken();
//        if (!$access_token) {
//            return response()->json('toke required!',401);
//        }
        //then we need check if received token is valid in personal_access_tokens table

        return $next($request);
    }
}
