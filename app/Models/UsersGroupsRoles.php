<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersGroupsRoles extends Model
{
    //use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_group_id', 'role_id'
    ];

    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\UsersGroup', 'users_group_id');
    }
}
