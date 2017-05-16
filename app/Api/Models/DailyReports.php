<?php
/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 16.05.17
 * Time: 16:21
 */

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReports extends Model
{
    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'task_id',
        'report',
    ];

    /**
     * Relation for User.
     *
     * @param
     * @return
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Relation for Status.
     *
     * @param
     * @return
     */
    public function tasks()
    {
        return $this->belongsToMany('App\Api\Models\Task');
    }
}