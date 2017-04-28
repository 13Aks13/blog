<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'role_id' => $user->role,
            'staus_id' => $user->userStatus,
            'isBloked' => $user->isBloked,
            'goal' => $user->goal,
            'added' => date('Y-m-d', strtotime($user->created_at)),
            'updated' => date('Y-m-d', strtotime($user->updated_at))
        ];
    }
}