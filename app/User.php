<?php

namespace App;

use File;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'goal',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $avatarPath = '/storage/avatars';

    /*
     *   Custome Methods
     */
    public function getAvatarStoragePath()
    {
        return $this->avatarPath . '/' . $this->id;
    }

    public function getAvatarStorageFullPath()
    {
        $path = public_path() . $this->getAvatarStoragePath();
        if(!is_dir($path)) {
            File::makeDirectory($path, 0775, true);
        }
        return $path;
    }

    public function getAvatarAttribute($value)
    {
        if (is_null($value)) {
            return null;
        } else {
            return $this->getAvatarStoragePath() . '/' . $value;
        }
    }

    public function deleteAvatar()
    {
        if (!is_null($this->avatar)) {
            $file = public_path() . $this->avatar;

            if (is_file($file)) {
                unlink($file);
                $this->avatar = null;
            }
        }
        return true;
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'assigneTo_id', 'id');
    }

    public function createdTasks()
    {
        return $this->hasMany('App\Models\Task', 'createdBy_id', 'id');
    }

    public function isAdmin()
    {
        if ($this->role->title === 'role_admin') {
            return true;
        } else {
            return false;
        }
    }

    public function userStatus()
    {
        return $this->belongsTo('App\Models\UserStatus', 'status_id', 'id');
    }

    public function remember_token($token)
    {
       $this->remember_token=$token;
       $this->save();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->attributes['id'];
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }
}
