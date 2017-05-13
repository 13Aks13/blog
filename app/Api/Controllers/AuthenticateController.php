<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 28.04.17
 * Time: 13:07
 */

namespace App\Api\Controllers;

use Dingo\Api\Facade\API;
use JWTAuth;
use App\User;
use App\Api\Models\Statistics;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class AuthenticateController extends BaseController
{

    public function me(Request $request)
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        //$credentials = json_decode($request->getContent(), true);
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


        //save token to DB
        $user = User::where('email', $credentials['email'])->first();
        $user->remember_token($token);

        // all good so return the token
        return response()->json(compact(['token', 'user'] ));
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }


    public function validateToken()
    {
        // Our routes file should have already authenticated this token, so we just return success here
        return API::response()->array(['status' => 'success'])->statusCode(200);
    }

    public function register(Request $request)
    {
        $newUser = [
            'name' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role' => 2,
        ];

        $user = User::create($newUser);
        $token = JWTAuth::fromUser($user);
        $user->remember_token($token);

        // Set default status -> 1 - Offline
        $status = new Statistics;
        $status->user_id = $user->id;
        $status->status_id = 1;
        $status->save();

        return response()->json(compact('token'));
    }

}