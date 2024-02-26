<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClusterRequest;
use App\Http\Resources\ClusterCompactResource;
use App\Models\Cluster;
use App\Models\User;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    public function index($id)
    {
        $clusters = Cluster::query()->where('user_id', $id)->get();
        return response()->json(['status' => 'success', 'data' => ClusterCompactResource::collection($clusters)]);
    }

    public function show(ClusterRequest $request){
       //
    }
}
