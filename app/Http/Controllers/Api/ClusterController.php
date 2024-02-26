<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClusterResource;
use App\Models\Cluster;
use App\Models\User;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    public function show($id)
    {
        $clusters = Cluster::query()->where('user_id', $id)->get();
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection($clusters)]);
    }
}
