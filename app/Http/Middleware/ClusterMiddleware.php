<?php

namespace App\Http\Middleware;

use App\Models\Cluster;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClusterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $validated_data = $request->validate([
            'cluster_id' => 'required|exists:clusters,id|integer',
            'password' => 'string|required'
        ]);

        $cluster = Cluster::query()->where('user_id', auth()->user()->id)->where('id', $validated_data['cluster_id'])->first();
        if ($validated_data['password'] != $cluster->password) {
            return response()->json([
                'status' => 403,
                'message' => 'forbidden password'
            ], 403);
        }
        app()->instance('cluster', $cluster);
        return $next($request);
    }
}
