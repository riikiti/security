<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckPassword\CheckPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckPasswordController extends Controller
{
    public function __invoke(CheckPasswordRequest $request, CheckPasswordAction $checkPasswordAction)
    {
        return $checkPasswordAction->checkPassword($request->validated()['password']);
    }
}
