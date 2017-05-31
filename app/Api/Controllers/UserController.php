<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 28.04.17
 * Time: 9:20
 */

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Api\Transformers\UserTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\User;
use Api\Requests\UserRequest;

class UserController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Show all user
     *
     * Get a JSON representation of all the users
     *
     * @Get('/')
     */
    public function index()
    {
        return $this->collection(User::all(), new UserTransformer);
    }

    /**
     * Store a new user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        return User::create($request->only(['first_name', 'last_name', 'email', 'password', 'goal', 'birthday', 'skype', 'phone', 'title']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(User::findOrFail($id), new UserTransformer);
    }

    /**
     * Update the user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['first_name', 'last_name', 'email', 'password', 'goal', 'birthday', 'skype', 'phone', 'title']));
        return $user;
    }


    public function avatar(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $user->avatar = $request->input('avatar');
        $user->save();
        return $user;
    }


}


