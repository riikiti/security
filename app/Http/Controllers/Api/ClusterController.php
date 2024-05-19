<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cluster\ClusterCompactRequest;
use App\Http\Requests\Cluster\ClusterRequest;
use App\Http\Requests\Cluster\ClusterStoreRequest;
use App\Http\Requests\Records\RecordsStoreRequest;
use App\Http\Requests\Search\SearchRecordsRequest;
use App\Http\Resources\Cluster\ClusterRecordsResource;
use App\Http\Resources\Cluster\ClusterResource;
use App\Http\Resources\RecordsResource;
use App\Models\Cluster;
use App\Models\CompanyClusters;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Services\Helpers\Encryption\EncryptionHelperService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class ClusterController extends Controller
{
    private array $data;
    private Cluster $cluster;
    private User $user;
    private EncryptionHelperService $encryptHelper;

    public function __construct()
    {
        $this->encryptHelper = app(EncryptionHelperService::class);
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
        foreach ($clusters as $cluster) {
            // $cluster->name = $this->encryptHelper->decrypt($cluster->name, $cluster->password);
        }
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection($clusters)]);
    }

    public function show(): JsonResponse
    {
        $this->cluster = resolve('cluster');
        //$this->cluster->name = $this->encryptHelper->decrypt($this->cluster->name, $this->cluster->password);
        return response()->json(['status' => 'success', 'data' => ClusterRecordsResource::make($this->cluster)]);
    }

    public function update(ClusterRequest $request): JsonResponse
    {
        $this->permissions($request->cluster_id);

        $cluster = Cluster::query()->where('id', $request->cluster_id)->first();
        $this->setClusterParameters($this->data, $request, $cluster->password);
        $cluster->fill($this->data)->save();
        return response()->json(['status' => 'success', 'data' => ClusterRecordsResource::make($cluster)]);
    }

    public function store(ClusterStoreRequest $request): JsonResponse
    {
        $this->permissions($request->cluster_id);
        $this->data = $request->validated();
        $this->data['password'] = Hash::make($this->data['password']);
        // $this->data['name'] = $this->encryptHelper->encrypt($this->data['name'], $this->data['password']);
        $this->cluster = Cluster::create($this->data);
        $this->cluster->fill(['user_id' => $this->user->id])->save();
        return response()->json(['status' => 'success', 'data' => ClusterResource::make($this->cluster)]);
    }

    public function delete(Cluster $cluster): JsonResponse
    {
        $cluster->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }

    public function setClusterParameters(&$data, $request, $password): array
    {
        if (isset($request->new_password)) {
            $data['password'] = Hash::make($request->new_password);
            $data['name'] = $request->name;
        }
        $data['name'] = $request->name;
        // $data['name'] = $this->encryptHelper->encrypt($request->name, $password);
        return $data;
    }

    public function search(SearchRecordsRequest $request): JsonResponse
    {
        $clusters = Cluster::query()
            ->where('name', 'LIKE', '%' . $request->find . '%')
            ->get();
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection($clusters)]);
    }

    public function permissions($cluster_id)
    {
        $clusterUser = CompanyClusters::query()->where('user_id', $this->user->id)->where(
            'cluster_id',
            $cluster_id
        )->first();
        if (!$clusterUser?->is_redactor) {
            return response()->json(['status' => 'permission denied', 'data' => []]);
        }
    }
}
