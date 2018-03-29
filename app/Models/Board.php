<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board_name', 'description', 'meta'
    ];

    public function project()
    {
        return $this->hasMany('App\Models\Project', 'board_id');
    }
    
    public function columns()
    {
        return $this->hasMany('App\Models\Column', 'board_id');

    }
}
