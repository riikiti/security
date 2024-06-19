<?php

use App\Actions\CheckPasswordAction;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CheckPasswordController;
use App\Http\Controllers\Api\ClusterController;
use App\Http\Controllers\Api\CompanyClusterController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\PasswordGenController;
use App\Http\Controllers\Api\RecordsController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [RegisterController::class, 'register'])->withoutMiddleware('api');
});


Route::middleware(['check-token', 'is_banned', 'api'])->group(function () {
    Route::group(['prefix' => 'clusters'], function () {
        Route::get('/', [ClusterController::class, 'index']);
        Route::get('show', [ClusterController::class, 'show'])->middleware('cluster-password');
        Route::post('update', [ClusterController::class, 'update']);
        Route::post('store', [ClusterController::class, 'store']);
        Route::post('delete/{cluster}', [ClusterController::class, 'delete']);
        Route::post('search', [ClusterController::class, 'search']);
        Route::post('search-company', [ClusterController::class, 'searchInCompany']);
    });

    Route::group(['prefix' => 'records'], function () {
        Route::get('/', [RecordsController::class, 'index']);
        Route::get('show', [RecordsController::class, 'show']);
        Route::post('update', [RecordsController::class, 'update']);
        Route::post('store', [RecordsController::class, 'store']);
        Route::post('delete/{record}', [RecordsController::class, 'delete']);
        Route::post('search', [RecordsController::class, 'search']);
    });
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('show', [UserController::class, 'show']);
        Route::post('update', [UserController::class, 'update']);
        Route::post('delete', [UserController::class, 'delete']);
    });

    Route::group(['prefix' => 'company'], function () {
        Route::post('store', [CompanyController::class, 'store']);
        Route::post('user', [CompanyController::class, 'addUser']);
        Route::get('show', [CompanyController::class, 'show']);
        Route::get('users', [CompanyController::class, 'showUsers']);
        Route::get('current-user', [CompanyController::class, 'showCurrentUser']);
        Route::post('update', [CompanyController::class, 'update']);
        Route::post('delete-user', [CompanyController::class, 'deleteUser']);
        Route::post('delete', [CompanyController::class, 'delete']);
        Route::post('search-user', [CompanyController::class, 'searchUsersInCompany']);
    });

    Route::group(['prefix' => 'role'], function () {
        Route::post('/add-role', [RoleController::class, 'addRole']);
        Route::get('/all-role', [RoleController::class, 'allRole']);
        Route::post('/add-user-role', [RoleController::class, 'addUserRole']);
        Route::get('/search-user-by-role', [RoleController::class, 'searchUsersByRole']);
        Route::post('/update', [RoleController::class, 'updateRole']);
        Route::post('/delete', [RoleController::class, 'deleteRole']);
        Route::post('/search', [RoleController::class, 'searchRole']);
    });

    Route::apiResource('company-cluster', CompanyClusterController::class)->except('destroy');

    Route::post('/company-cluster/create', [CompanyClusterController::class,'addCluster']);

    Route::get('company-cluster/users/show', [CompanyClusterController::class,'allUsersCompanyClusters']);
    Route::post('company-cluster/users/delete/', [CompanyClusterController::class,'destroy']);
});


Route::get('code', [PasswordGenController::class, 'index']);
Route::get('/password', CheckPasswordController::class);






