<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 05.05.17
 * Time: 11:32
 */

namespace App\Api\Controllers;


use App\Http\Controllers\Controller;
use App\Api\Models\UserStatus;
use App\Api\Transformers\UserStatusesTransformer;
use Dingo\Api\Http\Request;
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


    public function name(Request $request)
    {
        return $this->item(UserStatus::findOrFail($request->input('id' )), new UserStatusesTransformer);
    }


    public function getChildStatuses(Request $request)
    {
        return UserStatus::where('parent_id', $request->input('id'))->get();
    }

}