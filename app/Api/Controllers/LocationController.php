<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 25.05.17
 * Time: 14:11
 */

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Api\Transformers\LocationTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Response;
use Dingo\Api\Routing\Helpers;
use App\Api\Models\Location;
use DB;

class LocationController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


    /**
     * Show all locations
     *
     * Get a JSON representation of all the locations
     *
     * @Get('/')
     */
    public function index()
    {
        return $this->collection(Location::all(), new LocationTransformer);
    }
}