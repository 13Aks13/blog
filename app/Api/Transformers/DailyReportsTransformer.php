<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 16.05.17
 * Time: 16:24
 */

namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Api\Models\DailyReports;

class DailyReportsTransformer extends TransformerAbstract
{
    public function transform(DailyReports $dailyReports)
    {
        return [
            'id' => (int) $dailyReports->id,
            'user_id' => (int) $dailyReports->user_id,
            'status_id' => (int) $dailyReports->status_id,
            'report' => $dailyReports->report,
            'added' => date('Y-m-d', strtotime($dailyReports->created_at)),
        ];
    }
}