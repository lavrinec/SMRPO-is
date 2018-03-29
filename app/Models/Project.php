<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board_name', 'description', 'buyer_name', 'start_date','end_date',
    ];

    

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }

    public function board()
    {
        return $this->belongsTo('App\Models\Board');
    }
}
