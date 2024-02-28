<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserToCompanyRequest;
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
    public function store(CompanyStoreRequest $request)
    {
        return CompanyResource::make(Company::create($request->validated()));
    }

    public function addUser(AddUserToCompanyRequest $request)
    {
        $new_user_info = $request->validated();
        $user = User::find($new_user_info['user_id']);
        $user->fill($new_user_info)->save();
        return UserCompactResorce::make($user);
    }

    public function show(CompanyRequest $request)
    {
        $company = Company::find($request->company_id);
        return CompanyResource::make($company);
    }

    public function showUsers(CompanyRequest $request)
    {
        $company = Company::find($request->company_id);
        return CompanyUserstResorce::make($company);
    }
}
