<?php
namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Requests\Users\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request): UserResource
    {
        try {
            $fb = new \Facebook\Facebook([
                'app_id' => '{app-id}',
                'app_secret' => '{app-secret}',
                'default_graph_version' => 'v2.10'
            ]);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return response()->json(
                ['error' => 'Unexpected authentication configuration error.'],
                500
            );
        }

        try {
            $response = $fb->get('/me', $request->input('access_token'));
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return response()->json(['error' => 'Unexpected authentication error.'], 500);
        }

        // Create the user if it doesn't exist yet
        $user = User::firstOrCreate(
            ['facebook_id', $response->id],
            [
                'first_name' => $response->first_name,
                'last_name' => $response->last_name,
                'email' => $response->email
            ]
        );

        // Manually auth the user
        Auth::login($user);

        return $this->respondWithToken($user);
    }

    protected function respondWithToken($user): UserResource
    {
        return (new UserResource($user))->additional([
            'meta' => ['access_token' => $user->api_token]
        ]);
    }
}
