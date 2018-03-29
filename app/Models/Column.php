<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use SoftDeletes;

    public function parent()
    {
        return $this->belongsTo('App\Models\Column', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Column', 'parent_id');
    }

    public function board()
    {
        return $this->belongsTo('App\Models\Board', 'board_id');
    }

    public function cards()
    {
        return $this->hasMany('App\Models\Cards', 'column_id');
    }
}
