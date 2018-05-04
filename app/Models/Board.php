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

    public function projects()
    {
        return $this->hasMany('App\Models\Project', 'board_id');
    }
    
    public function columns()
    {
        return $this->hasMany('App\Models\Column', 'board_id');
    }

    public function structuredColumns()
    {
        return $this->orderdParentColumns()->with('allChildren');
    }

    public function orderdParentColumns()
    {
        return $this->columns()->whereNull('parent_id')->orderBy('order');
    }

    public function structuredColumnsCards()
    {
        return $this->orderdParentColumns()->with('allChildrenCards')->with(['cards' => function ($query) {
            $query->with('project', 'user');
        }]);
    }

    public function cards()
    {
        return $this->hasManyThrough('App\Models\Card', 'App\Models\Column', 'board_id', 'column_id');
    }

    public function groups()
    {
        return $this->hasManyThrough('App\Models\Group', 'App\Models\Project', 'board_id', 'id', 'id', 'group_id');
    }

    //TODO move to service, to havy models!

    /**
     * @return Column
     */
    public function lowestRightColumn(){
        $columns = $this->columns();
        $column = $columns->where('parent_id', null)->with('allLastChildren')->orderBy('order', 'desc')->first();
        return $this->getLowestRightColumn($column);
    }

    /**
     * @return Column
     */
    public function lowestLeftColumn(){
        $columns = $this->columns();
        $column = $columns->where('parent_id', null)->where('left_id', null)->with('leftChild')->orderBy('order')->first();
        return $this->getLowestLeftColumn($column);
    }

    /**
     * @param Column $column
     * @return Column
     */
    private function getLowestLeftColumn(Column $column)
    {
        if(! $column || ! $column->leftChild) return $column;
        $column = $column->leftChild()->with('leftChild')->first();
        if(! $column || ! $column->leftChild)
            return $column;
        else
            return $this->getLowestLeftColumn($column);
    }

    /**
     * @param Column $column
     * @return Column
     */
    private function getLowestRightColumn(Column $column)
    {
        if(! $column || count($column->allLastChildren) < 1)
            return $column;
        else {
            return $this->getLowestRightColumn($column->allLastChildren->first());
        }
    }
}
