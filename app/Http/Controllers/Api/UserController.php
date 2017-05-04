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
        $this->middleware('jwt.auth');
    }

    /**
     * Show all dogs
     *
     * Get a JSON representation of all the dogs
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
        return User::create($request->only(['name', 'email']));
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
     * Update the dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $dog = User::findOrFail($id);
        $dog->update($request->only(['name', 'age']));
        return $dog;
    }

    public function getUsers()
    {
        $users = User::all();

        return $this->response->collection($users, new UserTransformer);
    }


}


