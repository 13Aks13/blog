<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 28.04.17
 * Time: 9:20
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;
use App\User;

class UserController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('api.auth');

        // Only apply to a subset of methods.
        //$this->middleware('api.auth', ['only' => ['index']]);
    }

    public function index()
    {
        $user = $this->auth->user();

        return $user;
    }


    public function getUsers()
    {

        $users = User::all();

        return $this->response->collection($users, new UserTransformer);
//
//        $users = User::paginate(2);
//
//        return $this->response->paginator($users, new UserTransformer);

    }

    public function getUser($id)
    {
        $user = User::findOrFail($id);

//        return $this->response->array($user->toArray());
        return $this->response->collection($user, new UserTransformer);

    }

}


