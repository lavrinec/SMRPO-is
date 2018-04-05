<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = Board::withTrashed()->get();
        return view('boards.list')->with('boards', $boards);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($validator = $this->validateBoard($request)) return redirect()->route('boards.create')->withErrors($validator);

        $data = request()->except('_token');
        $board = new Board($data);
        $board->save();
        request()->session()->flash(
            'message', 'Uspešno kreirana tabla.'
        );

        return redirect()->route('boards.show', $board);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board $board
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $board = Board::withTrashed()->where('id', $id)->first();

        return view('boards.show')->with('board', $board);
    }

    public function validateBoard(Request $request, $board = false)
    {
        $validator = Validator::make($request->all(), [
            'board_name' => 'required|max:255',
        ],
            [
                'required' => 'Polje ne sme ostati prazno!',
                'max' => 'Maksimalna dolžina je največ 255 znakov!',
            ]);
        if ($validator->fails()) {
            return $validator;
        }

        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board $board
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $board = Board::where('id', $id)->with('projects')->first();
        $projects = Project::all();
        return view('boards.edit')->with('board', $board)->with('projects', $projects);
    }

    public function addColumn(Request $request)
    {
        $column_id = "aa" . str_random(20);
        $parent_id = $request->parent_id;
        $parent_name = $request->parent_name;
        $left_id = $request->left_id;
        $level = $request->level;

        return view('boards.column')->with([
            'column_id' => $column_id,
            'parent_id' => $parent_id,
            'parent_name' => $parent_name,
            'left_id' => $left_id,
            'level' => $level,
        ]);
    }

    private $tranmitionArray = [];


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Board $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        //dd($request, $board);
        //return "test";
        if ($validator = $this->validateBoard($request, $board->id)) {
            return redirect()->route('boards.edit', $board->id)->withErrors($validator);
        }

        $boardData = request()->except('_token', 'projects', 'column');
        $board->update($boardData);

        //add project data - ni potestirano, update board ni se narejen
        $project_ids = $request->input('projects');
        if(isset($project_ids) && count($project_ids) > 0) {
            Project::where(function ($query) use ($board) {
                $query->where('board_id', '!=', $board->id)
                    ->orWhereNull('board_id');
            })->whereIn('id', $project_ids)->update(['board_id' => $board->id]);
        } else
            $project_ids = [];
        Project::where('board_id', $board->id)->whereNotIn('id', $project_ids)->update(['board_id' => null]);

        $order = 0;
        foreach ($request->column as $column){
            $order++;
            $this->processColumn($board->id, $column, $order);
        }



        return redirect()->route('boards.show', $board);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $board->delete();
        return redirect()->route('boards.list');
    }

    private function processColumn($boardId, $column, $order, $parent = null)
    {
        //$column['parent_id'] = $this->processThroughArray($column, 'parent_id');
        $column['parent_id'] = $parent;
        $column['left_id'] = $this->processThroughArray($column, 'left_id');
        $column['start_border'] = $this->checkTypes($column, 'start_border');
        $column['end_border'] = $this->checkTypes($column, 'end_border');
        $column['high_priority'] = $this->checkTypes($column, 'high_priority');
        $column['acceptance_testing'] = $this->checkTypes($column, 'acceptance_testing');
        $column['board_id'] = $boardId;
        $column['order'] = $order;
        $column['WIP'] = $column['wip'];

        $children = isset($column['childs']) ? $column['childs'] : [];

        unset($column['parent_name'], $column['level'], $column['types'], $column['childs']);

        if( !is_int ($column['id'])){
            $old = $column['id'];
            $new = Column::create($column);
            $this->tranmitionArray[$old] = $new->id;

            $order = 0;
            foreach ($children as $child){
                $order++;
                $this->processColumn($boardId, $child, $order, $new->id);
            }

        }
        //dd($column);
    }

    private function processThroughArray($column, $key){
        if(!empty($column[$key])){
            if( !is_int ($column[$key])){
                if(isset($this->tranmitionArray[$column[$key]]))
                    return $this->tranmitionArray[$column[$key]];
                else
                    dd("Ni nastavljen", $column['parent_id'], $this->tranmitionArray[$column[$key]]);
            } else
                return $column[$key];
        } else
            return null;
    }

    private function checkTypes($column, $key)
    {
        if(isset($column['types']))
            return (! (empty($column['types'][$key])));
        else
            return false;
    }
}
