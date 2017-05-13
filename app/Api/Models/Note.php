<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function task()
    {
        return $this->belongsTo('App\Api\Models\Task');
    }
}
