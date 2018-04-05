<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'card_name', 'description', 'order', 'color', 'deadline', 'estimation', 'column_id', 'user_id', 'meta'
    ];

    public function column()
    {
        return $this->belongsTo('App\Models\Column', 'column_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }

    public function board()
    {
        return $this->column()->first()->board();
    }

    public function moves()
    {
        return $this->hasMany('App\Models\Move', 'card_id');
    }

    public function wipViolations()
    {
        return $this->hasMany('App\Models\WipViolation', 'card_id');
    }
}
