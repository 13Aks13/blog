<?php
/**
 * Created by PhpStorm.
 * User: Andrew K
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
    public function update(Request $request)
    {
        $statistics = Statistics::findOrFail($request->input( 'user_id' ));
        $seconds = $request->input( 'end' )->timestamp - $statistics->created_at->timestamp;
        $statistics->seconds = $seconds;
        $statistics->update($request->only(['user_id', 'status_id', 'seconds', 'end']));
        return $statistics->item($statistics, new StatisticsTransformer);
    }

    /**
     * Update current status for user
     *
     * @param Request $request
     * @return mixed
     */
//    public function updCurrentStatus(Request $request)
//    {
//        $status=Statistics::where([['user_id', $request->input( 'user_id' )], ['status_id', $request->input( 'status_id' )]])->latest()->first();
//        $status->seconds = time() - $status->created_at->timestamp;
//        $status->save();
//
//        return $this->item($status, new StatisticsTransformer);
//    }

    /**
     * Get current status for user to statistics
     *
     * @param Request $request
     * @return mixed
     */
    public function getCurrentStatus(Request $request)
    {
        $statistics = Statistics::where('user_id', $request->input( 'user_id' ))->latest()->first();
        if ($statistics) {
            return $this->item( $statistics, new StatisticsTransformer );
        }
        return $this->response->noContent();
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

        //dd($previous->toSql(), $previous->getBindings());
        if (!$previous) {
            $new = new Statistics();
            $new->user_id = $request->input( 'user_id' );
            $new->status_id = $request->input( 'status_id' );
            $new->created_at = time();
            $new->seconds = 0;
            $new->save();

            return $this->item($new, new StatisticsTransformer);
        }

        if ($previous->status_id != $request->input( 'status_id' )) {
            $new = new Statistics();
            $new->user_id = $request->input( 'user_id' );
            $new->status_id = $request->input( 'status_id' );
            $new->created_at = time();
            $new->seconds = 0;

            if ($new->save()) {
                $seconds = time() - $previous->created_at->timestamp;
                $previous->seconds = $seconds;
                // Convert UNIX time ti timestamp MySQL
                // https://stackoverflow.com/questions/5632662/saving-timestamp-in-mysql-table-using-php
                $previous->end = date('Y-m-d H:i:s',time());
                $previous->save();
            }
            return $this->item($new, new StatisticsTransformer);
        }
        return $this->response->noContent();
    }


    /**
     *
     * Get time for specific user and status
     *
     * @param Request $request
     * @return mixed
     */
    public function getTimeForSpecificStatus(Request $request)
    {
        // Current status
        $currentStatus = Statistics::where('user_id', $request->input( 'user_id' ))->latest()->first();
        $seconds = 0;
        if ($currentStatus) {
            $seconds = time() - $currentStatus->created_at->timestamp;
            $currentStatus->seconds = $seconds;
        }

        $status = DB::table('statistics')->select('status_id', DB::raw('SUM(NULLIF(seconds, 0)) as seconds'))
            ->where([['user_id', $request->input( 'user_id' )], ['status_id', $request->input( 'status_id' )]])
            ->whereBetween('created_at', [$request->input( 'start' ), $request->input( 'end' )])
            ->groupBy('status_id')->get()->first();


        if ($status) {
            // Current status === $status in this day with previous end time
            if ($currentStatus) {
                if ($currentStatus->status_id === $status->status_id) {
                    // Add current time to perevious
                    $time = gmdate( "H:i:s", $status->seconds + $seconds);
                } else {
                    // Status time
                    $time = gmdate( "H:i:s", $status->seconds );
                }
            } else {
                // Status time
                $time = gmdate( "H:i:s", $status->seconds );
            }
            $status->seconds = $time;
            return Response::json($status);
        } else {
            //If db has only current status
            if ($currentStatus) {
                $currentStatus->seconds = gmdate("H:i:s", $seconds);
                return Response::json($currentStatus);
            }
            return Response::json(['status_id'=> '0', 'parent_id'=> '0', 'seconds'=> '00:00:00']);
        }
    }


    /**
     * Get all statuses time with parent ID
     *
     * @param Request $request
     * @return mixed
     */
    public function getTimeForAll(Request $request)
    {
        $status = DB::table('statistics')->select(DB::raw('SUM(seconds) as seconds'))
            ->where('user_id', $request->input('user_id'))
            ->whereIn('status_id', $request->input('status_id'))
            ->whereBetween('created_at', [$request->input( 'start' ), $request->input( 'end' )])
            ->first();

        // dd($status->toSql(), $status->getBindings());
        if($status) {
            $time = gmdate("H:i:s", $status->seconds);
            $status->seconds = $time;
            return Response::json($status);
        }
        return Response::json(['status_id'=> $request->input('status_id'), 'parent_id'=> '0', 'seconds'=> '00:00:00']);
    }


    /**
     *
     * Get last status for user
     *
     * @param Request $request
     * @return mixed
     */
    public function getStatusTimeForUser(Request $request)
    {
        $status = DB::table('statistics')->select('status_id', DB::raw('SUM(seconds) as seconds'))
            ->where('user_id', $request->input('user_id'))
            ->whereBetween('created_at', [$request->input( 'start' ), $request->input( 'end' )])
            ->whereBetween('updated_at', [$request->input( 'start' ), $request->input( 'end' )])
            ->last();

        if($status) {
            $time = gmdate("H:i:s", $status->seconds);
            $status->seconds = $time;
            return Response::json($status);
        }
        return Response::json(['status_id'=> $request->input('status_id'), 'parent_id'=> '0', 'seconds'=> '00:00:00']);
    }


    /**
     *
     * Get all users statuses for date
     *
     * @param Request $request
     * @return mixed
     */
    public function getAllStatuses(Request $request)
    {
        // All active statuses for users
        $currentStatus = Statistics::whereNull('end')->get();
        if($currentStatus) {
            foreach ( $currentStatus as $cs ) {
                $seconds = time() - $cs->created_at->timestamp;
                $cs->seconds = $seconds;
            }
        }

        //DB::enableQueryLog();
        $status = DB::table('statistics')->select('user_id', 'status_id', DB::raw('SUM(seconds) as seconds'))
            ->whereNotNull('end')
            ->whereBetween('created_at', [$request->input( 'start' ), $request->input( 'end' )])
            ->groupBy('user_id', 'status_id')
            ->get();
        //dd($status->toSql(), $status->getBindings());
        //dd(DB::getQueryLog(), $status);
        //$obj = new \stdClass();

        if ($currentStatus && $status) {
            foreach ($currentStatus as $ct) {
                $existStatus = false;
                foreach ($status as $st) {
                    if (($ct->user_id === $st->user_id) && ($ct->status_id === $st->status_id)) {
                        $st->seconds = $st->seconds + $ct->seconds;
                        $existStatus = true;
                        break;
                    }
                }

                if ($existStatus === false) {
                    $object = new \StdClass();
                    $object->user_id = $ct->user_id;
                    $object->status_id = $ct->status_id;
                    $object->seconds = $ct->seconds;
                    $status->push($object);
//                    $status->push(collect(['user_id' => $ct->user_id, 'status_id' => $ct->status_id, 'seconds' => $ct->seconds]));
                }

            }
        }

        if($status) {
            foreach ($status as $st) {
                $time = gmdate( "H:i:s", $st->seconds );
                $st->seconds = $time;
            }
            $newArr = [];
            $status->groupBy('user_id')->map(function ($item, $key) use(&$newArr) {
                $arr = [];
                $item->map(function($item) use(&$newArr, &$arr) {
                    $arr[$item->status_id] = $item->seconds;
                });
                $newArr[$key] = $arr;
            });
            //  dd($newArr);
            return Response::json($newArr);
        }
        return $this->response->noContent();
    }

}