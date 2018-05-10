<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use App\Models\Project;
use App\Models\Move;
use App\Models\Card;
use App\Models\MoveReason;
use App\Models\UsersGroup;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

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

public function report($id){
    $projects = Project::where('board_id', $id)->get();
    $board = Board::where("id", $id)->first();
    //return $projects;
    return view('boards.report')->with('projects', $projects)->with("board", $board);
}

public function makeReport(Request $request){

    $project = $request->projects;
    $types = $request->types;

    $board = $request->board;
    $full_board = Board::where("id", $board)->first();

    $projects = Project::where('board_id', $board)->get();
    $all_projects=Project::where("board_id", $board)->pluck("id");
    
    //get all cards for this board
    $Cards = Card::whereIn("project_id", $all_projects)->get();
    
    //get cards for chosen projects
    if ($project) {
        $Cards = $Cards->whereIn('project_id', $project);        
    }

    //get cards for chosen types
    if ($types) {
        $total=new Collection([]);
        foreach($types as $type){
            switch ($type) {
                case "is_silver_bullet":
                    $total =$total->merge($Cards->where("is_silver_bullet", 1));
                    break;
                case "is_rejected":
                    $total =$total->merge($Cards->where("is_rejected", 1));            
                    break;
                case "normal":
                    $total =$total->merge($Cards->where("is_rejected", '<>', 1)->where("is_silver_bullet", '<>', 1));
                    break;
                }
            }    
        $Cards = $total;
    }

    //get cards by estimated time required
    if ($request->time_start!=null && $request->time_end!=null) {        
        $Cards = $Cards->where('estimation', '>=', $request->time_start)->where('estimation', '<', $request->time_end);       
        }
    
    //get cards by time of their creation
    if ($request->creation_start && $request->creation_end) {
        $Cards = $Cards->where('created_at', '>=', $request->creation_start)->where('created_at', '<', $request->creation_end);
    }

    //premaknjen iz acceptance testinga - potegni notri se board ID
    $acceptance_column = Column::where("board_id", $board)->where("acceptance_testing", 1)->first();
    $after_acceptance_column=Column::where("left_id", $acceptance_column->id)->first();
    $id = $after_acceptance_column->id;
    //while ($child = Column::where("parent_id", $id)) $after_acceptance_column = $child;

    //get cards by end of development
    if ($request->finish_start && $request->finish_end) {
        $moves = Move::where("old_column_id", $acceptance_column->id)->where("new_column_id", $after_acceptance_column->id)
                ->where('created_at', '>=', $request->finish_start)->where('created_at', '<', $request->finish_end)->get();
        $cards = new Collection([]);
        
        foreach($moves as $move){
            $cards->push($move->card);
        }
        $ids = $cards->unique("id")->pluck("id");
        $Cards = $Cards->whereIn("id", $ids);
    }

    $dev_start_column = Column::where("board_id", $board)->where("start_border", 1)->first();

    //get cards by start of development
    if ($request->dev_start && $request->dev_end) {
        $moves = Move::where("new_column_id", $dev_start_column->id)
                ->where('created_at', '>=', $request->dev_start)->where('created_at', '<', $request->dev_end)->get();
                $cards = new Collection([]);        
        foreach($moves as $move){
            $cards->push($move->card);
        }         
        $ids = $cards->unique("id")->pluck("id"); 
        $Cards = $Cards->whereIn("id", $ids);
    }
    //return $request;
    //$start = Move::where("new_column_id", 15)->where("card_id", 6)->first();
    //$end = Move::where("new_column_id", $end_column_id)->where("card_id", $card_id)->first();
    $start_column = $request->start_column;
    $end_column = $request->end_column;

    $no_cards_with_time=0;
    $total_time=0;
    $leaves = array_map('intval', explode(",", $request->leaves));

    foreach ($Cards as $card){
        
        $lead = $this->calculateLeadTime($card->id, $start_column,$end_column, $leaves);

        if(gettype($lead)!="string"){
            $card->lead = $this->formatTime($lead, $request->show_time);
            $no_cards_with_time++;
            $total_time+=$lead;
        }else{
            $card->lead = $lead;
        }
    }  
    $average_time=0; 
    if($no_cards_with_time!=0){
        $average_time=$total_time/$no_cards_with_time;
    }
    
    #return $lead_times;
    
    #return "to je lead time ".$lead;
    #return $Cards;

    $formatted=$this->formatTime($average_time, $request->show_time);
    //return [$average_time, $formatted];
    $old_request = $request;
    request()->flash();
    return view("boards.report")->with("cards",$Cards)->with("board", $full_board)->with('projects', $projects)
    ->with("average_time", $formatted)->with("old_request", $old_request);
}

private function formatTime($time, $format){
    switch($format){  case "d":
        return number_format($time/(60*24), 1, ",",".")." d";
        break;
        case "h":
        return number_format($time/60, 1, ",",".")." h";
        break;
        case "m":
        return number_format((float)$time, 1, ",",".")." m";
        break;}
      

    // $min = $minutes%60;
    // $hours=($minutes/60)%24;
    // $days = (int)($minutes/(60*24));
    // $formatted = $days." d, ".$hours.":".$min;
    // return $formatted;
}

private function cardInColumnTime($card_id, $column_id){
    $start = Move::where("new_column_id", $column_id)->where("card_id", $card_id)->first();
    $end = Move::where("old_column_id", $column_id)->where("card_id", $card_id)->first();
    
    //kartica se ni prisla do tega stolpca
    if($start==null) return "kartica še ni v tem stolpcu";

    $start_Date = $start->created_at;
    if($end == null) $end_Date = Carbon::now();    
    else $end_Date = $end->created_at;
    $leadTime = $end_Date->diffInMinutes($start_Date);
    return $leadTime;
}



private function calculateLeadTime($card_id, $start_column_id, $end_column_id, $leaves){
    $leadTime =0;
    //poisci premik kartice v prvi stolpec
    $start = Move::where("new_column_id", $start_column_id)->where("card_id", $card_id)->first();

    $skip_final = false;

    $start_index = array_search($start_column_id, $leaves);
    $end_index = array_search($end_column_id, $leaves);

    //return [$start_index,$end_index];
    //dokler ne prides do zadnjega stolpca v chainu premikov
    while ($start_column_id!=$end_column_id){
        //ce kartica ni bila v prvem stolpcu pojdi do naslednje kartice, kjer je bila
        if ($start==null){
            $start_index++;
            while($start_index<=$end_index){
                $start_column_id = $leaves[$start_index];
                $start = Move::where("new_column_id", $start_column_id)->where("card_id", $card_id)->first();
                if($start!=null) break;
                $start_index++;
            }
            //if($card_id == 21)return $start;
            if($start==null){
                return "kartica ni bila v izbranih stolpcih";
            }
            
        }

        $test = Move::where("new_column_id", $start_column_id)->where("card_id", $card_id)->first();

        //if ($test == null) return "start ne dela";

        $leadTime += $this->cardInColumnTime($card_id, $start_column_id);
        $next=Move::where("old_column_id",$start_column_id)->where("card_id", $card_id)->first();
        //ce si prisel do konca verige preden si prisel do koncnega stolpca preskoci racunanje koncnega stolpca
        if($next==null) {
            $skip_final = true;
            break;
        }        
        $start_column_id = $next->new_column_id;
    }

    if(!$skip_final){
        //izracunaj koncni stolpec
        $lead = $this->cardInColumnTime($card_id, $start_column_id);
        
    if (gettype($lead)=="string"){
        return $lead;
    }
    $leadTime+=$lead;
    }

    return $leadTime;
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
        $user = Auth::user();
        $board = Board::where('id', $id)->with('projects', 'structuredColumnsCards')->first();
        if ($board == null) {
            return redirect()->route('boards.list')->withErrors(['NoBoard' => 'Tabla ne obstaja, ali je bila zbrisana']);
        }
        $userGroups = UsersGroup::where('user_id', $user->id)->with('role')->get();
        //$columns = Column::where('board_id', $id)->whereNull('parent_id')->orderBy('order')->with('allChildren')->get();
        //dd($board);
        $projects = Project::all();

        //$this->getUsersGroupsOfBoard($id);

        return view('boards.focus')->with('board', $board)->with('projects', $projects)->with('userGroups',$userGroups);
    }

//    public function getUsersGroupsOfBoard($boardid){
//        $groups = DB::table("groups")->whereExists(function($query){
//           $query->DB::table("projects")->where('groups.id', '=' ,'projects.group_id');
//        })->get();
//
//    }

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

        // move silver bullets and rejected cards if column type (high_priority) was changed
        $silverBulletCards = Board::where('id', $board->id)->first()->cards->where('is_silver_bullet', 1);
        $rejectedCards = Board::where('id', $board->id)->first()->cards->where('is_rejected', 1);

        $highPriorityColumn = Column::where('board_id', $board->id)->where('high_priority', 1)->first();

        foreach($silverBulletCards as $sbcard){
            $old_column_id = $sbcard->column_id;

            Card::where('id', $sbcard->id)->update(array('column_id' => $highPriorityColumn->id));
            checkWipViolation($sbcard, "Nov stolpec za nujne kartice ima omejitev WIP manjso od stevila kartic!");

            $move = [
                'card_id' => $sbcard->id,
                'old_order' => $sbcard->order,
                'user_id' => Auth::user()->id,
                'old_column_id' => $old_column_id,
                'new_column_id' => $highPriorityColumn->id
            ];
            Move::create($move);

        }

        foreach($rejectedCards as $rcard){
            $old_column_id = $rcard->column_id;

            Card::where('id', $rcard->id)->update(array('column_id' => $highPriorityColumn->id));
            checkWipViolation($rcard, "Nov stolpec za nujne kartice ima omejitev WIP manjso od stevila kartic!");

            $move = [
                'card_id' => $rcard->id,
                'old_order' => $rcard->order,
                'user_id' => Auth::user()->id,
                'old_column_id' => $old_column_id,
                'new_column_id' => $highPriorityColumn->id
            ];
            Move::create($move);
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
