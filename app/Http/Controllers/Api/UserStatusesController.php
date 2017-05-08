<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 05.05.17
 * Time: 11:32
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\UserStatus;
use App\Transformers\UserStatusesTransformer;
use Dingo\Api\Routing\Helpers;

class UserStatusesController extends Controller
{

    use Helpers;


    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Show all statuses for user
     *
     * Get a JSON representation of all the statuses
     *
     * @Get('/')
     */
    public function index()
    {

        return $this->collection(UserStatus::all(), new UserStatusesTransformer);
    }
}