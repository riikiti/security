<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCompanyRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyUserstResorce;
use App\Http\Resources\UserCompactResorce;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    private User $user;

    public function __construct()
    {
        $this->middleware('check-token');
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function store(CompanyStoreRequest $request)
    {

        return response()->json(['status' => 'success', 'data' => CompanyResource::make(Company::create($request->validated()))]);
    }

    public function addUser(UserCompanyRequest $request)
    {
        $new_user_info = $request->validated();
        $user = User::find($new_user_info['user_id']);
        $user->fill($new_user_info)->save();
        return response()->json(['status' => 'success', 'data' => UserCompactResorce::make($user)]);
    }

    public function show(CompanyRequest $request)
    {
        $company = Company::query()->where('id', $request->company_id)->where('owner_id', $this->user->id)->first();
        return response()->json(['status' => 'success', 'data' => CompanyResource::make($company)]);
    }

    public function showUsers(CompanyRequest $request)
    {
        $company = Company::query()->where('id', $request->company_id)->where('owner_id', $this->user->id)->first();
        return response()->json(['status' => 'success', 'data' => CompanyUserstResorce::make($company)]);
    }

    public function update(CompanyRequest $request)
    {
        $new_company_info = $request->validated();
        $company = Company::query()->where('id', $new_company_info['company_id'])->where('owner_id', $this->user->id)->first();
        $company->fill($new_company_info)->save();
        return response()->json(['status' => 'success', 'data' => CompanyResource::make($company)]);
    }

    public function deleteUser(UserCompanyRequest $request)
    {
        $company = Company::query()->where('id', $request->company_id)->where('owner_id', auth()->user()->id)->first();
        $user = User::query()->where('id',$request->user_id);
        if ($user->company_id == $company->id) {
            $user->fill(['company_id' => null])->save();
            return response()->json(['status' => 'error', 'data' => UserCompactResorce::make($this->user)]);
        }
        if ($company){
            return response()->json(['status' => 'denied', 'data' => 'Your dont owner']);
        }
        return response()->json(['status' => 'error', 'message' => 'user not in company']);
    }

    public function delete(CompanyRequest $request)
    {
        $company = Company::query()->where('id', $request->company_id)->where('owner_id', $this->user->id)->first();
        $company->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }
}
