<?php
Route
    ::prefix('v1')
    ->namespace('Api\V1')
    ->group(function () {

        // Auth
        Route::post('auth/login', 'AuthController@login');
        Route::post('auth/register', 'AuthController@register');

    });