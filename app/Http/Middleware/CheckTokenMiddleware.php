<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        switch (true) {
            case !request()->bearerToken():
                return response()->json([
                    'status' => 403,
                    'message' => 'token dont enter'
                ]);
            case auth()->user() == null:
                return response()->json([
                    'status' => 404,
                    'message' => 'forbidden token'
                ]);
            default :
                return $next($request);
        }
    }
}
