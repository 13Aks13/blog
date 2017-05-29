<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 10.05.17
 * Time: 10:21
 */

namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\Models\Statistics;

class StatisticsTransformer extends TransformerAbstract
{
    public function transform(Statistics $statistics)
    {
        return [
            'id' => (int) $statistics->id,
            'user_id' => (int) $statistics->user_id,
            'status_id' => (int) $statistics->status_id,
            'start' => date('Y-m-d', strtotime($statistics->created_at)),
            'end' => date(strtotime($statistics->end)),
            'seconds' => $statistics->seconds, //gmdate("H:i:s", $statistics->seconds)
        ];
    }

}