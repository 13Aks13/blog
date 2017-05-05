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

class UserStatusesController extends Controller
{
    /**
     * Show all statuses for user
     *
     * Get a JSON representation of all the dogs
     *
     * @Get('/')
     */
    public function index()
    {
        return $this->collection(UserStatus::all(), new UserStatusesTransformer);
    }
}