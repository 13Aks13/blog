<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 10.05.17
 * Time: 10:13
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Transformers\StatisticsTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Statistics;


class StatisticsController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Show all statistics
     *
     * Get a JSON representation of all the users
     *
     * @Get('/')
     */
    public function index()
    {
        return $this->collection(Statistics::all(), new StatisticsTransformer);
    }


}