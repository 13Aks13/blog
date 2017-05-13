<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 05.05.17
 * Time: 11:10
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\UserStatus;


class UserStatusesTransformer extends TransformerAbstract
{
    public function transform(UserStatus $userStatus)
    {
        return [
            'status_id' => $userStatus->id,
            'status_name' => $userStatus->name,
            'status_color' => $userStatus->color
        ];
    }
}