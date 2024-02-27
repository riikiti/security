<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UpdateUserController extends Controller
{
    public function update(UserUpdateRequest $request)
    {
        $new_user_info = $request->validated();
        $user = User::find($new_user_info['user_id']);
        $user->fill($new_user_info)->save();
        return response()->json(['status' => 'success', 'data' => UserResource::make($user)]);
    }
}
