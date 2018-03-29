<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_name', 'description', 'meta'
    ];

    public function usersGroups()
    {
        return $this->hasMany('App\Models\UsersGroup', 'group_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'users_groups');
    }

    public function project()
    {
        return $this->hasMany('App\Models\Project', 'group_id');
    }
}
