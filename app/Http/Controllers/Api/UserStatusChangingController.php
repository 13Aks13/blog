<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 28.04.17
 * Time: 11:31
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Transformers\UserStatusChangingTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\UserStatusChanging;


class UserStatusChangingController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


    /**
     * Show all statuses for users
     *
     * Get a JSON representation of all the user statuses
     *
     * @Get('/')
     */
    public function index()
    {
        return $this->collection(UserStatusChanging::all(), new UserStatusChangingTransformer);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(UserStatusChanging::findOrFail($id), new UserStatusChangingTransformer);
    }


    /**
     * Display the specified resource by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($user_id)
    {
        return $this->item(UserStatusChanging::where('user_id', $user_id)->first(), new UserStatusChangingTransformer);
    }

    /**
     * Store a new status for user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return UserStatusChanging::create($request->only('user_id', 'status_id'));
    }

}