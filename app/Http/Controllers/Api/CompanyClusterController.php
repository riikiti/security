<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cluster\ClusterStoreRequest;
use App\Http\Requests\Company\CompanyAddUserToClusterRequest;
use App\Http\Requests\Company\CompanyUpdateUserToClusterRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\Cluster\ClusterResource;
use App\Http\Resources\Company\CompanyClustersUsersResource;
use App\Http\Resources\CompanyCompactResource;
use App\Models\Cluster;
use App\Models\CompanyClusters;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

//        if (!$user?->is_redactor || $user?->is_redactor == null) {
//            return response()->json([
//                'status' => 'denied',
//                'data' => 'permission denied'
//            ]);
//        }
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
        $cluster = Cluster::create($request->validated());
        return response()->json(['status' => 'success', 'data' => ClusterResource::make($cluster)]);
    }

}
