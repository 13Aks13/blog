<?php

namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'role' => $user->role,
            'isBloked' => $user->isBloked,
            'goal' => $user->goal,
            'added' => date('Y-m-d', strtotime($user->created_at)),
            'updated' => date('Y-m-d', strtotime($user->updated_at))
        ];
    }
}