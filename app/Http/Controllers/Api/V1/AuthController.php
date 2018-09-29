<?php
namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\Users\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request): UserResource
    {
        // Grab Facebook user details
        $response = Socialite::driver('facebook')->userFromToken($request->input('token'));

        // Get first & last name
        $fullname = $response->getName();
        $name_parts = explode(' ', $fullname);
        $lastname = array_pop($name_parts);
        $firstname = implode(' ', $name_parts);

        // Create the user if it doesn't exist
        $user = User::firstOrCreate(
            ['facebook_id', $response->getId()],
            [
                'first_name' => $firstname,
                'last_name' => $lastname,
                'avatar_url' => $response->getAvatar(),
                'email' => $response->getEmail()
            ]
        );

        // Manually auth the user
        Auth::login($user);

        // Return the user with its api access token
        return $this->respondWithToken($user);
    }

    protected function respondWithToken($user): UserResource
    {
        return (new UserResource($user))->additional([
            'meta' => ['api_access_token' => $user->api_token]
        ]);
    }
}
