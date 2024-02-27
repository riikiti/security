<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ClusterController;
use App\Http\Controllers\Api\PasswordGenController;
use App\Http\Controllers\Api\RecordsController;
use App\Http\Controllers\Api\UpdateUserController;
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

//todo refactor routes to apiResource

Route::middleware(['check-token'])->group(function () {
    Route::group(['middleware' => 'cluster-password', 'prefix' => 'clusters'], function () {
        Route::get('/', [ClusterController::class, 'index'])->withoutMiddleware('cluster-password');
        Route::get('show', [ClusterController::class, 'show']);
        Route::post('update', [ClusterController::class, 'update']);
        Route::post('store', [ClusterController::class, 'store'])->withoutMiddleware('cluster-password');
        Route::post('delete', [ClusterController::class, 'delete']);
    });

    Route::group(['prefix' => 'records'], function () {
        Route::get('/', [RecordsController::class, 'index']);
        Route::get('show', [RecordsController::class, 'show']);
        Route::post('update', [RecordsController::class, 'update']);
        Route::post('store', [RecordsController::class, 'store']);
        Route::post('delete', [RecordsController::class, 'delete']);
    });
});

Route::get('code', [PasswordGenController::class, 'index']);
Route::post('update-user',[UpdateUserController::class,'update']);


