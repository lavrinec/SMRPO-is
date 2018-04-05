<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'column_name', 'description', 'order', 'WIP','start_border', 'end_border', "high_priority", "acceptance_testing", "meta", "parent_id", "board_id", "left_id",
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Column', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Column', 'parent_id')->orderBy('order');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function leftChild()
    {
        return $this->hasOne('App\Models\Column', 'parent_id')->where('left_id', null);
    }

    public function board()
    {
        return $this->belongsTo('App\Models\Board', 'board_id');
    }

    public function cards()
    {
        return $this->hasMany('App\Models\Card', 'column_id');
    }
}
