<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Error;

class UserController extends Controller
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

    public function index()
    {
        return response()->json(['status' => 'success', 'data' => UserResource::collection(User::all())]);
    }

    public function show()
    {

        return response()->json(['status' => 'success', 'data' => UserResource::make(User::find($this->user->id))]);
    }

    public function update(UserUpdateRequest $request)
    {
        $new_user_info = $request->validated();
        $user = User::find($this->user->id);
        $user->fill($new_user_info)->save();
        return response()->json(['status' => 'success', 'data' => UserResource::make($user)]);
    }

    public function delete()
    {
        $user = User::find($this->user->id);
        $user->delete();
        return response()->json(['status' => 'success', 'data' => []]);
    }
}
