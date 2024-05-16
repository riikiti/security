<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasBannedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user =  auth()->user();
        if ( $user->is_banned)
        {
            return response()->json(['status'=>'banned','data'=>"$user->name забанен"]);
        }
        return $next($request);
    }
}
