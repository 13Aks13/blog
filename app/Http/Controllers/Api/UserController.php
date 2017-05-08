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
        return User::create($request->only(['name', 'email', 'password', 'goal']));
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
        $user->update($request->only(['name', 'email', 'password', 'goal']));
        return $user;
    }

    /**
     * Update the current status for user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['status_id']));
        return $user;
    }


    /**
     * Create the current status for user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setCurrentStatus(Request $request)
    {
//        DB::table('user_status_changing')->insert(
//            ['user_id' => $request->input('user_id'), 'status_id' => $request->input('status_id')]
//        );
        $user = User::findOrFail($request->input('user_id'));
        $user->userStatus()->attach($request->input('status_id'));
        return $user;
    }

}


