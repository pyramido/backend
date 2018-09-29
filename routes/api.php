<?php
Route
    ::prefix('v1')
    ->namespace('Api\V1')
    ->group(function () {
        /**
         ************************
         *
         * PROTECTED ROUTES
         *
         ************************
         */
        Route::middleware('auth:api')->group(function () {
            Route::apiResource('events', 'EventController');
            Route::apiResource('events/{event}/rewards', 'RewardController');
            Route::apiResource('invites', 'InviteController');
            Route::apiResource('participations', 'ParticipationController');
        });

        /**
         ************************
         *
         * PUBLIC ROUTES
         *
         ************************
         */

        // Auth
        Route::post('auth/login', 'AuthController@login');

        Route::apiResource('events', 'EventController', ['only' => ['index', 'show']]);
    });
