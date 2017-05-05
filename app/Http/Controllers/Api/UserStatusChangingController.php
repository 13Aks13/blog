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
use Dingo\Api\Routing\Helpers;
use App\Models\UserStatusChanging;


class UserStatusChangingController extends Controller
{
    use Helpers;

    public function getUserStatuses()
    {
        $userStatus = UserStatusChanging::all();

        return $this->response->collection($userStatus, new UserStatusChangingTransformer);
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
     * Store a new status for user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStatusChanging $request)
    {
        return UserStatusChanging::create($request->only(['user_id', 'status_id']));
    }

}