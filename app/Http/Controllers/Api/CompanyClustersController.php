<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyClustersResource;
use App\Models\CompanyClusterUsers;
use http\Encoding\Stream\Debrotli;
use Illuminate\Http\Request;

class CompanyClustersController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 'success', 'data' => CompanyClustersResource::collection(CompanyClusterUsers::all())]);
    }

    public function store(){
        
    }
}
