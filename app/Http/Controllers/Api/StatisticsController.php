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
     *
     * Update
     *
     * @param Request $request
     * @return mixed
     */
    public function updCurrentStatus(Request $request)
    {
        $status=Statistics::where([['user_id', $request->user_id], ['status_id', $request->status_id]])->latest()->first();
        $status->second = time() - $status->created_at;
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
        return $this->item(Statistics::where([['user_id', $request->user_id], ['status_id', $request->status_id]])->latest()->first(), new StatisticsTransformer);
    }

    /**
     *
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


}