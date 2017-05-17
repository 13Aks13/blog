<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 16.05.17
 * Time: 16:29
 */

namespace App\Api\Controllers;


use App\Api\Models\DailyReports;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Dingo\Api\Http\Request;
use App\Api\Transformers\DailyReportsTransformer;

class DailyReportsController extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Show all statistics
     *
     * Get a JSON representation of all the reports
     *
     * @Get('/')
     */
    public function index()
    {
        return $this->collection(DailyReports::all(), new DailyReportsTransformer);
    }

    /**
     * Store a new report in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->item(DailyReports::create($request->only(['user_id', 'task_id', 'report'])), new DailyReportsTransformer);
    }



}