<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'card_name', 'move_reason_id', 'description', 'order', 'color', 'deadline', 'estimation',
        'column_id', 'user_id', 'project_id', 'meta',
        'is_critical', 'is_rejected', 'is_silver_bullet'
    ];

    public function column()
    {
        return $this->belongsTo('App\Models\Column', 'column_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function board()
    {
        return $this->column()->first()->board();
    }

    public function moves()
    {
        return $this->hasMany('App\Models\Move', 'card_id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'card_id');
    }

    public function wipViolations()
    {
        return $this->hasMany('App\Models\WipViolation', 'card_id');
    }

    /**
     * @return bool
     */
    public function isBeforeEnd(): bool
    {
        $lowestRight = $this->board()->first()->lowestRightColumn();
        return !isset($lowestRight) || $this->column_id != $lowestRight->id;
    }


    /**
     * @return bool
     */
    public function isBeforeStart(): bool
    {
        $lowestLeft = $this->board()->first()->lowestLeftColumn();
        return !isset($lowestLeft) || $this->column_id == $lowestLeft->id;
    }

    public function canEdit($id):bool
    {
        $project = $this->project()->with('group')->first();
        if(isset($project->group)) {
            return $project->group->usersGroups()->where('user_id', $id)->count() > 0;
        } else {
            return false;
        }
    }
}
