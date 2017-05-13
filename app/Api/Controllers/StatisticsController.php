<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 10.05.17
 * Time: 10:13
 */

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Api\Transformers\StatisticsTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Response;
use Dingo\Api\Routing\Helpers;
use App\Api\Models\Statistics;
use DB;


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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(Statistics::findOrFail($id), new StatisticsTransformer);
    }

    /**
     * Update the statistics in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $statistics = Statistics::findOrFail($id);
        $statistics->update($request->only(['user_id', 'status_id', 'seconds']));
        return $statistics->item($statistics, new StatisticsTransformer);
    }

    /**
     * Update current status for user
     *
     * @param Request $request
     * @return mixed
     */
    public function updCurrentStatus(Request $request)
    {
        $status=Statistics::where([['user_id', $request->input( 'user_id' )], ['status_id', $request->input( 'status_id' )]])->latest()->first();
        $status->seconds = time() - $status->created_at->timestamp;
        $status->save();

        return $this->item($status, new StatisticsTransformer);
    }

    /**
     * Get current status for user to statistics
     *
     * @param Request $request
     * @return mixed
     */
    public function getCurrentStatus(Request $request)
    {
        return $this->item(Statistics::where('user_id', $request->input( 'user_id' ))->latest()->first(), new StatisticsTransformer);
    }

    /**
     *  Get current status for user to statistics
     *
     * @param Request $request
     * @return mixed
     */
    public function setCurrentStatus(Request $request)
    {
        $previous = Statistics::where('user_id', $request->input( 'user_id' ))->latest()->first();

        if (!$previous) {
            $previous = new Statistics;
            $previous->user_id = $request->input( 'user_id' );
            $previous->status_id = 1;
            $previous->created_at = strtotime('today midnight');
            $previous->save();
        }

        if ($previous->status_id != $request->input( 'status_id' )) {
            $new = new Statistics();
            $new->user_id = $request->input( 'user_id' );
            $new->status_id = $request->input( 'status_id' ) ;

            if ($new->save()) {
                $seconds = $new->created_at->timestamp - $previous->created_at->timestamp;
                $previous->seconds = $seconds;
                $previous->save();
            }
            return $this->item($new, new StatisticsTransformer);
        }

        return $this;
    }

    public function getTimeForSpecificStatus(Request $request)
    {
        $status = DB::table('statistics')->select('status_id', DB::raw('SUM(NULLIF(seconds, 0)) as seconds'))
            ->where([['user_id', $request->input( 'user_id' )], ['status_id', $request->input( 'status_id' )]])
            ->whereBetween('created_at', [$request->input( 'start' ), $request->input( 'end' )])
            ->groupBy('status_id')->get()->first();

        if ($status) {
            $time = gmdate("H:i:s", $status->seconds);
            $status->seconds = $time;
            return Response::json($status);
        } else {
            return Response::json(['status_id'=> '0', 'seconds'=> '00:00:00']);
        }
    }
}