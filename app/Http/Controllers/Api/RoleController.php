<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleCompactRequest;
use App\Http\Requests\Role\RoleSearchRequest;
use App\Http\Requests\Role\RoleSearchUsersByRoleRequest;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUserRequest;
use App\Http\Requests\Search\SearchClusterRequest;
use App\Http\Resources\CompanyRoleCompactResource;
use App\Http\Resources\CompanyRoleResource;
use App\Http\Resources\UserCompactResorce;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserRoleResource;
use App\Models\CompanyRole;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //добавление роли в компании
    public function addRole(RoleStoreRequest $request): JsonResponse
    {
        return response()->json(
            ['status' => 'success', 'data' => CompanyRoleResource::make(CompanyRole::create($request->validated()))]
        );
    }

    //все роли компании
    public function allRole(RoleSearchRequest $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => CompanyRoleCompactResource::collection(
                    CompanyRole::query()->where('company_id', $request->company_id)->orWhere(
                        'company_id',
                        '=',
                        null
                    )->get()
                )
            ]
        );
    }

    //Добавление юзеру роли
    public function addUserRole(RoleUserRequest $request): JsonResponse
    {
        $user = User::query()->where('id', $request->user_id)->first();
        $user->fill(['role_id' => $request->role_id])->save();
        return response()->json(
            ['status' => 'success', 'data' => UserRoleResource::make($user)]
        );
    }

    //поиск по ролям
    public function searchUsersByRole(RoleSearchUsersByRoleRequest $request): JsonResponse
    {
        $users = User::query()->where('company_id', $request->company_id)->where('role_id', $request->role_id)->get();
        return response()->json(
            [
                'status' => 'success',
                'data' => UserCompactResorce::collection($users)
            ]
        );
    }

    public function searchRole(SearchClusterRequest $request): JsonResponse
    {
        $roles = CompanyRole::query()->where('role', 'LIKE', '%' . $request->find . '%');
        return response()->json(
            [
                'status' => 'success',
                'data' => CompanyRoleResource::collection($roles)
            ]
        );
    }

    public function updateRole(RoleCompactRequest $request): JsonResponse
    {
        $role = CompanyRole::query()->where('id', $request->role_id)->first();
        $role->fill(['role' => $request->role])->save();
        return response()->json(
            ['status' => 'success', 'data' => CompanyRoleResource::make($role)]
        );
    }


    public function deleteRole(RoleCompactRequest $request): JsonResponse
    {
        $role = CompanyRole::query()->where('id', $request->role_id)->first();
        $role->delete();
        return response()->json(
            ['status' => 'success', 'data' => []]
        );
    }
}
