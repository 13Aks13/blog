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

    $api->group(['namespace' => 'App\Http\Controllers\Api', 'middleware' => '\Barryvdh\Cors\HandleCors::class'], function ($api) {
        // Login route
        $api->post('login', 'AuthenticateController@authenticate');
        $api->post('register', 'AuthenticateController@register');

        // Middleware group route
        $api->group(['middleware' => 'jwt.auth'], function ($api) {

            $api->get('users/me', 'AuthenticateController@me');
            $api->get('validate_token', 'AuthenticateController@validateToken');



            // User
            $api->get('users', 'UserController@index');
            $api->post('users', 'UserController@store');
            $api->get('users/{id}', 'UserController@show');
            $api->delete('users/{id}', 'UserController@destroy');
            $api->put('users/{id}', 'UserController@update');

            // User current status
            $api->post('status', 'UserController@updateStatus');

            // User Statuses
            $api->get('statuses', 'UserStatusesController@index');

            // User Statuses Changing
            $api->post('changestatus', 'UserStatusChangingController@store');

        });
    });
});




//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
