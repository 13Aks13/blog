<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 28.04.17
 * Time: 9:20
 */

namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;
use App\User;

class UserController extends Controller
{
    use Helpers;

    public function getUsers()
    {

        $users = User::all();

        return $this->response->collection($users, new UserTransformer);

    }
}


