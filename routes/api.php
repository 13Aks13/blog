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

    $api->group(['middleware' => 'foo'], function ($api) {
        // Endpoints registered here will have the "foo" middleware applied.
    });

    $api->get('users', 'App\Http\Controllers\Api\UserController@getUsers');

    $api->get('test', function () {
        return 'It is ok';
    });

});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
