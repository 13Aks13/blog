<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 28.04.17
 * Time: 13:07
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Illuminate\Http\Request;


class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        // $credentials = $request->all('email', 'password');
        $credentials = json_decode($request->getContent(), true);
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
        return response()->json(compact('token'));
    }

}