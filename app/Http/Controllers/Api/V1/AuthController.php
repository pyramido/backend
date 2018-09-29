<?php
namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\StoreRequest;

class AuthController extends Controller
{
    public function register(StoreRequest $request): UserResource
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email
        ]);

        return $this->respondWithToken($user);
    }

    public function login(LoginRequest $request): UserResource
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = User::where('email', $request->input('email'))->first();
        return $this->respondWithToken($user);
    }

    protected function respondWithToken($user): UserResource
    {
        return (new UserResource($user))->additional([
            'meta' => ['access_token' => $user->api_token]
        ]);
    }
}
