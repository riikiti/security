<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cluster\ClusterStoreRequest;
use App\Http\Requests\Cluster\CompanyClusterShowUsersRequest;
use App\Http\Requests\Company\CompanyAddUserToClusterRequest;
use App\Http\Requests\Company\CompanyUpdateUserToClusterRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\Cluster\ClusterResource;
use App\Http\Resources\Cluster\CompanyClusterShowUsersResource;
use App\Http\Resources\Company\CompanyClustersUsersResource;
use App\Http\Resources\CompanyCompactResource;
use App\Models\Cluster;
use App\Models\Company;
use App\Models\CompanyClusters;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyClusterController extends Controller
{
    public function index(CompanyRequest $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => CompanyCompactResource::collection(
                    Cluster::query()->where('company_id', $request->company_id)->get()
                )
            ]
        );
    }

    public function show($id): JsonResponse
    {
        $companyClusters = CompanyClusters::query()->find($id);
        return response()->json(['status' => 'success', 'data' => CompanyClustersUsersResource::make($companyClusters)]
        );
    }

    public function store(CompanyAddUserToClusterRequest $request): JsonResponse
    {
        $user = CompanyClusters::query()->where('user_id', auth()->user()->id)->where(
            'cluster_id',
            $request->cluster_id
        )->first();

      /*  $company = Company::query()->where('owner_id', $user->id)->first();
        if (!$user?->is_redactor || $user?->is_redactor == null || empty($company)) {
            return response()->json([
                'status' => 'denied',
                'data' => 'permission denied'
            ]);
        }*/
        return response()->json(
            [
                'status' => 'success',
                'data' => CompanyClustersUsersResource::make(CompanyClusters::create($request->validated()))
            ]
        );
    }

    public function update($id, CompanyUpdateUserToClusterRequest $request): JsonResponse
    {
        $cluster = CompanyClusters::query()->find($id);
        $cluster->update($request->validated());
        return response()->json(['status' => 'success', 'data' => CompanyClustersUsersResource::make($cluster)]);
    }

    public function destroy($id): JsonResponse
    {
        $cluster = CompanyClusters::query()->find($id);
        $cluster->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }

    public function addCluster(ClusterStoreRequest $request): JsonResponse
    {
        $cluster = Cluster::create(['name'=>$request->name,'password'=>Hash::make($request->password),'company_id'=>$request->company_id]);
        CompanyClusters::create(['cluster_id' => $cluster->id,'user_id'=>auth()->user()->id,'is_redactor'=>true,'is_reader'=>true,'is_inviter'=>true]);
        return response()->json(['status' => 'success', 'data' => ClusterResource::make($cluster)]);
    }

    public function allUsersCompanyClusters(CompanyClusterShowUsersRequest $request): JsonResponse
    {
        $clusterUsers = CompanyClusters::query()->where('cluster_id', $request->cluster_id)->get();
        return response()->json(
            ['status' => 'success', 'data' => CompanyClusterShowUsersResource::collection($clusterUsers)]
        );
    }

}
