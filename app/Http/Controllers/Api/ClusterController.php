<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClusterCompactRequest;
use App\Http\Requests\ClusterRequest;
use App\Http\Resources\ClusterRecordsResource;
use App\Http\Resources\ClusterResource;
use App\Models\Cluster;
use Illuminate\Http\JsonResponse;


class ClusterController extends Controller
{
    public function index(ClusterCompactRequest $request): JsonResponse
    {
        $clusters = Cluster::query()->where('user_id', $request->user_id)->get();
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection($clusters)]);
    }

    public function show(ClusterRequest $request): JsonResponse
    {
        return response()->json(['status' => 'success', 'data' => ClusterRecordsResource::make(resolve('cluster'))]);
    }
}
