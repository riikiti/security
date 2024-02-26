<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cluster\ClusterCompactRequest;
use App\Http\Requests\Cluster\ClusterRequest;
use App\Http\Resources\Cluster\ClusterRecordsResource;
use App\Http\Resources\Cluster\ClusterResource;
use App\Models\Cluster;
use Illuminate\Http\JsonResponse;


class ClusterController extends Controller
{
    private array $data;
    private Cluster $cluster;

    public function __construct()
    {
        $this->data = [];
    }

    public function index(ClusterCompactRequest $request): JsonResponse
    {
        $clusters = Cluster::query()->where('user_id', $request->user_id)->get();
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection($clusters)]);
    }

    public function show(ClusterRequest $request): JsonResponse
    {
        $this->cluster = resolve('cluster');
        return response()->json(['status' => 'success', 'data' => ClusterRecordsResource::make($this->cluster)]);
    }

    public function update(ClusterRequest $request): JsonResponse
    {
        $this->cluster = resolve('cluster');
        $this->setClusterParameters($this->data, $request);
        $this->cluster->fill($this->data)->save();
        return response()->json(['status' => 'success', 'data' => ClusterRecordsResource::make($this->cluster)]);
    }

    public function delete(ClusterRequest $request): JsonResponse
    {
        $this->cluster = resolve('cluster');
        $this->cluster->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }

    public function setClusterParameters(&$data, $request): array
    {
        if (isset($request->new_password)) {
            $data['password'] = $request->new_password;
        }
        $data['user_id'] = $request->user_id;
        $data['cluster_id'] = $request->cluster_id;
        $data['name'] = $request->name;
        return $data;
    }
}
