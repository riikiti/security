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
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection(Cluster::query()->where('user_id', auth()->user()->id)->get())]);
    }

    public function show(): JsonResponse
    {
        return response()->json(['status' => 'success', 'data' => ClusterRecordsResource::make(resolve('cluster'))]);
    }

    public function update(ClusterRequest $request): JsonResponse
    {
        $cluster = Cluster::query()->where('id',$request->cluster_id)->first();
        $this->setClusterParameters($this->data, $request);
        $cluster->fill($this->data)->save();
        return response()->json(['status' => 'success', 'data' => ClusterRecordsResource::make( $cluster)]);
    }

    public function store(ClusterStoreRequest $request): JsonResponse
    {
        $this->data = $request->validated();
        $this->cluster = Cluster::create($this->data);
        $this->cluster->fill(['user_id' => $this->user->id])->save();
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
            $data['password'] = Hash::make($request->new_password);
            $data['name'] = $request->name;

        }
        return $data;
    }

    public function search(SearchRecordsRequest $request): JsonResponse
    {
        $clusters = Cluster::query()
            ->where('name', 'LIKE', '%' . $request->find . '%')
            ->get();
        return response()->json(['status' => 'success', 'data' => ClusterResource::collection($clusters)]);
    }
}
