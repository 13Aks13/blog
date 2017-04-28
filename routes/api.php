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

$api->version('v1', ['middleware' => 'auth'], function ($api) {

//    $api->group(['middleware' => 'api.auth'], function ($api) {
//
//    });

    $api->get('users', 'App\Http\Controllers\Api\UserController@getUsers');

});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
