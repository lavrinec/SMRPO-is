<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use App\Models\Card;
use App\Models\Project;
use App\Models\UsersGroup;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        //poisci vse table, na katerih so projekti tega userja
        if (!$user->isAdmin() && !$user->isKM()) {
            $usersGroup = UsersGroup::join('groups', "groups.id", "=", 'users_groups.group_id')->where('users_groups.user_id', $user->id)->get();
            //return $usersGroup;
            $groups = $user->groups()->get(); //NAPAKA - vrne tudi izbrisane iz skupine!!!
            //return $groups;
            $projects = [];
            foreach ($usersGroup as $gr) {
                $group = Group::where('id', $gr->group_id)->first();
                if ($group == null) {
                    continue;
                }
                $project = $group->project->all();

                $projects = array_merge($projects, $project);
            }
            $projects = array_unique($projects);
            //return $projects;
            $boards = [];
            foreach ($projects as $project) {
                if ($board = $project->board == null) continue;
                $board = $project->board;
                $boards = array_merge($boards, [$board]);

            }

            $boards = array_unique($boards);
        }

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
        if (isset($data['meta'])) {
            $data['meta'] = json_encode($data['meta']);
        }
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
        $board = $this->alsoJson(Board::withTrashed()->with('cards')->where('id', $id)->first());

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
//        $board = Board::where('id', $id)->with('projects', 'structuredColumns')->first();

        $board = $this->alsoJson(Board::where('id', $id)->with('projects', 'structuredColumnsCards')->first());
        //$columns = Column::where('board_id', $id)->whereNull('parent_id')->orderBy('order')->with('allChildren')->get();
        //dd($board);
        //na izbiro so samo projekti te table in projekti, ki se niso dodeljeni
        $projects = Project::where('board_id', null)->orWhere('board_id', $id)->get();
        return view('boards.edit')->with('board', $board)->with('projects', $projects);
    }

    /**
     * copy board
     *
     * @param  \App\Models\Board $board
     * @return \Illuminate\Http\Response
     */
    public function copy(Board $board)
    {
        $new = $board->replicate();
        $new->board_name .= ' _copy';
        $new->save();

        $columns = $board->structuredColumns()->get();
        $this->recursiveSaveColumns($new->id, null, $columns);

        //dd($board);
        return redirect()->route('boards.show', $new);
    }

    public function addColumn(Request $request)
    {
//        $cards = [];

        if ($request->column_data) {

            $column = $request->column_data;


            return view('boards.column')->with(['column' => $column]);

        } else {

            $column = [];


            $column["id"] = "aa" . str_random(20);
            $column["parent_id"] = $request->parent_id;
            $column["parent_name"] = $request->parent_name;
            $column["left_id"] = $request->left_id;
            $column["allChildrenCards"] = [];
            $column["cards"] = [];
//            $column["level"] = $request->level;

            return view('boards.column')->with(["column" => $column]);

//            return view('boards.column')->with([
//                'column_id' => $column_id,
//                'parent_id' => $parent_id,
//                'parent_name' => $parent_name,
//                'left_id' => $left_id,
//                'level' => $level,
////                'cards' => $cards
//            ]);
        }

    }

    /*
     * returns view for board with projects and cards
     *
     * */
    public function focus($id)
    {
        $board = Board::where('id', $id)->with('projects', 'structuredColumnsCards')->first();
        if ($board == null) {
            return redirect()->route('boards.list')->withErrors(['NoBoard' => 'Tabla ne obstaja, ali je bila zbrisana']);
        }
        //$columns = Column::where('board_id', $id)->whereNull('parent_id')->orderBy('order')->with('allChildren')->get();
        //dd($board);
        $projects = Project::all();
        return view('boards.focus')->with('board', $board)->with('projects', $projects);
    }

    public function columnHeader(Request $request)
    {
        return view('boards.columnHeader')->with(['column' => $request->column_data]);
    }

    public function columnBody(Request $request)
    {
        $cards = [];

        if (array_key_exists('cards', $request->column_data)) {
            $cards = $request->column_data['cards'];
        }

        $project_id = $request->project_id;

//        dd($cards);


        foreach ($cards as $card) {
            if ($card["project_id"] != $project_id) {
                unset($card);
            }
        }

        return view('boards.columnBody')->with(['cards' => $cards, 'project_id' => $project_id]);
    }


    function filterArray($value)
    {
        return ($value == 2);
    }

    public function columnShow(Request $request)
    {

        if ($request->column_data) {

            $cards = [];
            $projects = [];

            if (array_key_exists('cards', $request->column_data)) {
                $cards = $request->column_data['cards'];
            }

            if (array_key_exists('projects', $request->column_data)) {
                $projects = $request->column_data['projects'];
            }


            return view('boards.columnShow')->with([
                'column_id' => $request->column_data['id'],
                'parent_id' => $request->column_data['parent_id'],
                'parent_name' => $request->column_data['parent_name'],
                'left_id' => $request->column_data['left_id'],
                'level' => $request->column_data['level'],

                'column_name' => $request->column_data['column_name'],
                'description' => $request->column_data['description'],
                'WIP' => $request->column_data['WIP'],

                'start_border' => $request->column_data['start_border'],
                'end_border' => $request->column_data['end_border'],
                'high_priority' => $request->column_data['high_priority'],
                'acceptance_testing' => $request->column_data['acceptance_testing'],

                'cards' => $cards,
                'projects' => $projects,
            ]);
        } else {
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

    }


    private $tranmitionArray = [];
    private $allArray = [];


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
        if (isset($boardData['meta'])) {
            $boardData['meta'] = json_encode($boardData['meta']);
        }
        $board->update($boardData);


        //add project data
        $project_ids = $request->input('projects');

        //ce ni nobenih projektov nastavi na prazen seznam
        if (!isset($project_ids)) $project_ids = [];

        $deleted = Project::where('board_id', $board->id)->whereNotIn('id', $project_ids)->get();
        // $old =  Project::where('board_id', $board->id)->get();
        // $new = Project::whereIn('id', $project_ids)->get();


        //prepreci brisanje projektov, ki ze imajo kartice oz brisi ce jih nimajo        
        foreach ($deleted as $project) {
            if ($this->project_has_cards($project)) {
                return redirect()->back()->withErrors(['msg' => 'Projekt ' . $project->board_name . ' že ima kartice. Odstranite ga lahko šele po tem ko jih izbrišete.']);
            } else $project->update(['board_id' => null]);
        }

        //nastavi dodane projekte na tablo
        if (count($project_ids) > 0) {
            Project::where(function ($query) use ($board) {
                $query->where('board_id', '!=', $board->id)
                    ->orWhereNull('board_id');
            })->whereIn('id', $project_ids)->update(['board_id' => $board->id]);
        }


        $order = 0;
        if (!isset($request->column) || count($request->column) < 1) return redirect()->back()->withErrors(['msg' => 'Tabla je brez stolpcev!']);
        foreach ($request->column as $column) {
            $order++;
            $this->processColumn($board->id, $column, $order);
        }

        Column::where('board_id', $board->id)->whereNotIn('id', $this->allArray)->doesnthave('cards')->delete();

        $silverBulletCards = Board::where('id', $board->id)->first()->cards->where('is_silver_bullet', 1);
        $rejectedCards = Board::where('id', $board->id)->first()->cards->where('is_rejected', 1);

        $highPriorityColumn = Column::where('board_id', $board->id)->where('high_priority', 1)->first();

        foreach($silverBulletCards as $sbcard){
            Card::where('id', $sbcard->id)->update(array('column_id' => $highPriorityColumn->id));
            checkWipViolation($sbcard, "Nov stolpec za nujne kartice ima omejitev WIP manjso od stevila kartic!");
        }

        foreach($rejectedCards as $rcard){
            Card::where('id', $rcard->id)->update(array('column_id' => $highPriorityColumn->id));
            checkWipViolation($rcard, "Nov stolpec za nujne kartice ima omejitev WIP manjso od stevila kartic!");
        }

        return redirect()->route('boards.show', $board);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board $board
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $board = Board::where('id', $id)->first();
        //return $board;
        if ($this->board_has_cards($board)) {
            return redirect()->back()->withErrors(['msg' => 'Na tabli so kartice. Za izbris odstranite vse kartice']);
        }
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
        $column['WIP'] = isset($column['wip']) ? $column['wip'] : 0;

        $children = isset($column['childs']) ? $column['childs'] : [];

        unset($column['parent_name'], $column['level'], $column['types'], $column['childs'], $column['wip']);

        if (!is_numeric($column['id'])) {
            $old = $column['id'];
            $new = Column::create($column);
            $newId = $new->id;
            $this->tranmitionArray[$old] = $newId;

        } else {
            $newId = $column['id'];
            Column::where('id', $newId)->update($column);

            // check if new WIP is smaller than number of cards in column
            // save WIP violation for each card in column
            foreach (Column::where('id', $newId)->first()->cards as $card) {
                checkWipViolation($card, "Nova omejitev WIP manjsa od stevila kartic v stolpcu!");
            }

        }

        $this->allArray[] = $newId;

        $order = 0;
        foreach ($children as $child) {
            $order++;
            $this->processColumn($boardId, $child, $order, $newId);
        }
        //dd($column);
    }

    private function processThroughArray($column, $key)
    {
        if (!empty($column[$key])) {
            if (!is_numeric($column[$key])) {
                if (isset($this->tranmitionArray[$column[$key]]))
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
        if (isset($column['types']))
            return (!(empty($column['types'][$key])));
        else
            return false;
    }

    private function recursiveSaveColumns($boardId, $parentId, $columns)
    {
        $previous = null;
        foreach ($columns as $column) {
            $new = $column->replicate();
            $new->board_id = $boardId;
            $new->parent_id = $parentId;
            $new->left_id = $previous;
            $new->save();

            $this->recursiveSaveColumns($boardId, $new->id, $column->allChildren);

            $previous = $new->id;
        }
    }

    private function board_has_cards(Board $board)
    {
        foreach ($board->projects as $project) {
            if ($project->cards->count() > 0) return true;
        }
        return false;
    }

    private function project_has_cards(Project $project)
    {
        return $project->cards->count() > 0;
    }

    private function alsoJson($first)
    {
        $first->meta = json_decode($first->meta);
        return $first;
    }
}
