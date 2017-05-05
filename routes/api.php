<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [], function ($api) {

    $api->group(['middleware' => '\Barryvdh\Cors\HandleCors::class'], function ($api) {
        // Login route
        $api->post('login', 'App\Http\Controllers\Api\AuthenticateController@authenticate');
        $api->post('register', 'App\Http\Controllers\Api\AuthenticateController@register');

        // Middleware group route
        $api->group(['middleware' => 'jwt.auth'], function ($api) {

            $api->get('users/me', 'App\Http\Controllers\Api\AuthenticateController@me');
            $api->get('validate_token', 'App\Http\Controllers\Api\AuthenticateController@validateToken');

            // User
            $api->get('users', 'App\Http\Controllers\Api\UserController@index');
            $api->post('users', 'App\Http\Controllers\Api\UserController@store');
            $api->get('users/{id}', 'App\Http\Controllers\Api\UserController@show');
            $api->delete('users/{id}', 'App\Http\Controllers\Api\UserController@destroy');
            $api->put('users/{id}', 'App\Http\Controllers\Api\UserController@update');

            // User Statuses
            $api->get('users', 'App\Http\Controllers\Api\UserStatusesController@index');


            // User Statuses Changing
            $api->post('users', 'App\Http\Controllers\Api\UserStatusChanging@store');

        });
    });
});




//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
