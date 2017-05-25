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
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'role' => $user->role,
            'location' => $user->location,
            'isBloked' => $user->isBloked,
            'goal' => $user->goal,
            'birthday' => $user->birthday,
            'skype' => $user->skype,
            'phone' => $user->phone,
            'title' => $user->title,
            'added' => date('Y-m-d', strtotime($user->created_at)),
            'updated' => date('Y-m-d', strtotime($user->updated_at))
        ];
    }
}