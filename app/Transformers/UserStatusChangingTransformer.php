<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
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
            'id' => $userStatus->id,
            'user_id' => $userStatus->users,
            'status_id' => $userStatus->userstatus,
            'start_time' => date('Y-m-d', strtotime($userStatus->created_at)),
            'start_finish' => date('Y-m-d', strtotime($userStatus->update_at)),
        ];
    }
}