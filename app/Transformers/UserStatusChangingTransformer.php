<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 28.04.17
 * Time: 11:40
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\UserStatusChanging;


class UserStatusChangingTransformer extends TransformerAbstract
{
    public function transform(UserStatusChanging $userStatus)
    {
        return [
            'user_id' => $userStatus->users,
            'status_id' => $userStatus->userstatus,
            'start_time' => date('Y-m-d', strtotime($userStatus->created_at)),
        ];
    }
}