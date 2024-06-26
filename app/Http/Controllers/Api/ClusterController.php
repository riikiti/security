<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cluster\ClusterCompactRequest;
use App\Http\Requests\Cluster\ClusterRequest;
use App\Http\Requests\Cluster\ClusterStoreRequest;
use App\Http\Requests\Records\RecordsStoreRequest;
use App\Http\Requests\Search\SearchClusterRequest;
use App\Http\Requests\Search\SearchRecordsRequest;
use App\Http\Requests\Search\SearchUserInCompanyRequest;
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
        $hasCluster = CompanyClusters::query()->where('cluster_id', $this->cluster->id)->where(
            'user_id',
            auth()->user()->id
        )->first();
        if (!$hasCluster && $this->cluster->company_id != null) {
            return response()->json(['status' => 'success', 'data' => ['message' => "Доступ запрещен"]]);
        }
        //$this->cluster->name = $this->encryptHelper->decrypt($this->cluster->name, $this->cluster->password);
        return response()->json(['status' => 'success', 'data' => ClusterRecordsResource::make($this->cluster)]);
    }

    public function update(ClusterRequest $request): JsonResponse
    {
        $this->permissions($request->cluster_id);

        $cluster = Cluster::query()->where('id', $request->cluster_id)->first();
        //$this->setClusterParameters($this->data, $request, $cluster->password);

        if ($request->new_password === $request->new_password_confirm && isset($request->new_password)) {
            $cluster->fill(['password' => Hash::make($request->new_password)])->save();
        }
        if (isset($request->name)) {
            $cluster->fill(['name' => $request->name])->save();
        }
        //$cluster->fill($this->data)->save();
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
        $this->cluster->fill(['password' => Hash::make($this->data['password'])])->save();
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

    public function search(SearchClusterRequest $request): JsonResponse
    {
        $clusters = Cluster::query()
            ->where('name', 'LIKE', '%' . $request->find . '%')
            ->where('user_id', auth()->user()->id)
            ->get();
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection($clusters)]);
    }

    public function searchInCompany(SearchUserInCompanyRequest $request): JsonResponse
    {
        $clusters = Cluster::query()
            ->where('name', 'LIKE', '%' . $request->find . '%')->where('company_id', $request->company_id)
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
