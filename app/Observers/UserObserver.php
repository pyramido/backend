<?php
namespace App\Observers;

use App\User;
use App\ApiToken;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  User $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->api_token = ApiToken::generate();
    }
}
