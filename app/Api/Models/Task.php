<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'points',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Api\Models\Note');
    }

    public function CreatedBy()
    {
        return $this->belongsTo('App\User', 'createdBy_id', 'id');
    }

    public function AssigneTo()
    {
        return $this->belongsTo('App\User', 'assigneTo_id', 'id');
    }

}
