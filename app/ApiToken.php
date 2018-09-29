<?php
namespace App;

class ApiToken
{
    /**
     * Return a unique personal access token.
     *
     * @return String
     */
    public static function generate(): string
    {
        do {
            $api_token = str_random(60);
        } while (User::where('api_token', $api_token)->exists());

        return $api_token;
    }
}
