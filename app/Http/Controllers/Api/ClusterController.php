<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cluster\ClusterCompactRequest;
use App\Http\Requests\Cluster\ClusterRequest;
use App\Http\Requests\Cluster\ClusterStoreRequest;
use App\Http\Requests\Records\RecordsStoreRequest;
use App\Http\Resources\Cluster\ClusterRecordsResource;
use App\Http\Resources\Cluster\ClusterResource;
use App\Http\Resources\RecordsResource;
use App\Models\Cluster;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class ClusterController extends Controller
{
    private array $data;
    private Cluster $cluster;
    private User $user;

    public function __construct()
    {
        $this->data = [];
        $this->middleware('check-token');
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function index(): JsonResponse
    {
        $clusters = Cluster::query()->where('user_id', $this->user->id)->get();
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection($clusters)]);
    }

    public function show(): JsonResponse
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

    public function store(ClusterStoreRequest $request): JsonResponse
    {
        $this->cluster = Cluster::create($request->validated());
        return response()->json(['status' => 'success', 'data' => ClusterResource::make($this->cluster)]);
    }

    public function delete(): JsonResponse
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
        $data['user_id'] = $this->user->id;
        $data['cluster_id'] = $request->cluster_id;
        $data['name'] = $request->name;
        return $data;
    }
}
