<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 10.05.17
 * Time: 10:21
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Statistics;

class StatisticsTransformer extends TransformerAbstract
{
    public function transform(Statistics $statistics)
    {
        return [
            'id' => $statistics->id,
            'user_id' => $statistics->user_id,
            'status_id' => $statistics->status_id,
            'seconds' => $statistics->seconds,
            'added' => date('Y-m-d', strtotime($statistics->created_at)),
        ];
    }
}