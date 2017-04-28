<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 28.04.17
 * Time: 11:31
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;
use App\Models\UserStatusChanging;


class UserStatusChangingController extends Controller
{
    use Helpers;

    public function getUserStatuses()
    {
        $userStatus = UserStatusChanging::all();

        return $this->response->collection($userStatus, new UserTransformer);
    }

}